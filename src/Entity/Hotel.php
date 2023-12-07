<?php

// src/Entity/Hotel.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="name_hotel")
     */
    private $nameHotel;


    /**
     * @ORM\Column(type="float", name="rating_hotel")
     */
    private $ratingHotel;

    /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, name="image_hotel", nullable=true)
     */
    private $imageHotel;

    /**
     * @ORM\Column(type="text", name="description_hotel", nullable=true)
     */
    private $descriptionHotel;
    /**
     * @ORM\Column(type="integer", name="number_of_rooms", nullable=true)
     */
    private $numberOfRooms;

   /**
     * @ORM\OneToMany(targetEntity="Booking", mappedBy="hotel")
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

    public function getNameHotel(): ?string
    {
        return $this->nameHotel;
    }

    public function setNameHotel(string $nameHotel): self
    {
        $this->nameHotel = $nameHotel;

        return $this;
    }

    public function getRatingHotel(): ?float
    {
        return $this->ratingHotel;
    }

    public function setRatingHotel(float $ratingHotel): self
    {
        $this->ratingHotel = $ratingHotel;

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

    public function getImageHotel(): ?string
    {
        return $this->imageHotel;
    }

    public function setImageHotel(?string $imageHotel): self
    {
        $this->imageHotel = $imageHotel;

        return $this;
    }

    public function getDescriptionHotel(): ?string
    {
        return $this->descriptionHotel;
    }

    public function setDescriptionHotel(?string $descriptionHotel): self
    {
        $this->descriptionHotel = $descriptionHotel;

        return $this;
    }
    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(?int $numberOfRooms): self
    {
        $this->numberOfRooms = $numberOfRooms;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking[] = $booking;
            $booking->setHotel($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
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
        return $this->nameHotel;
    }

}

