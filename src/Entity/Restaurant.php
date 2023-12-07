<?php

// src/Entity/Restaurant.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="name_restaurant")
     */
    private $nameRestaurant;

    /**
     * @ORM\Column(type="float", name="rating_restaurant")
     */
    private $ratingRestaurant;
     /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    
    private $type;
    /**
     * @ORM\Column(type="integer", name="number_of_rooms", nullable=true)
     */
    private $numberOfTable;
    /**
     * @ORM\Column(type="string", length=255, name="image_restaurant", nullable=true)
     */
    private $imageRestaurant;

    /**
     * @ORM\Column(type="text", name="description_restaurant", nullable=true)
     */
    private $descriptionRestaurant;
    /**
     * @ORM\OneToMany(targetEntity="BookingRestaurant", mappedBy="restaurant")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRestaurant(): ?string
    {
        return $this->nameRestaurant;
    }

    public function setNameRestaurant(string $nameRestaurant): self
    {
        $this->nameRestaurant = $nameRestaurant;

        return $this;
    }

    public function getRatingRestaurant(): ?float
    {
        return $this->ratingRestaurant;
    }

    public function setRatingRestaurant(float $ratingRestaurant): self
    {
        $this->ratingRestaurant = $ratingRestaurant;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImageRestaurant(): ?string
    {
        return $this->imageRestaurant;
    }

    public function setImageRestaurant(?string $imageRestaurant): self
    {
        $this->imageRestaurant = $imageRestaurant;

        return $this;
    }

    public function getDescriptionRestaurant(): ?string
    {
        return $this->descriptionRestaurant;
    }

    public function setDescriptionRestaurant(?string $descriptionRestaurant): self
    {
        $this->descriptionRestaurant = $descriptionRestaurant;

        return $this;
    }
    public function getNumberOfTable(): ?int
    {
        return $this->numberOfTable;
    }

    public function setNumberOfTable(?int $numberOfTable): self
    {
        $this->numberOfTable = $numberOfTable;

        return $this;
    }
     /**
     * @return Collection<int, BookingRestaurant>
     */
    public function getBookingsRes(): Collection
    {
        return $this->booking;
    }

    public function addBookingRes(BookingRestaurant $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking[] = $booking;
            $booking->setHotel($this);
        }

        return $this;
    }

    public function removeBookingRes(BookingRestaurant $booking): self
    {
        if ($this->hotel_id->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getHotel() === $this) {
                $booking->setHotel(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nameRestaurant;
    }

}
