<?php

// src/Entity/Vol.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Vol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="nom_vol")
     */
    private $nomVol;
    /**
     * @ORM\Column(type="string", length=255, name="image")
     */
    private $image;
     /**
     * @ORM\Column(type="integer", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Billet", mappedBy="vol", orphanRemoval=true)
     */
    private $billets;
    /**
     * @ORM\OneToMany(targetEntity="BookingVol", mappedBy="volB")
     */
    private $bookings;
       /**
     * @ORM\Column(type="datetime", name="start_date")
     */
    private $startDate;
    
    public function __construct()
    {
        $this->billets = new ArrayCollection();
       
    }
    public function __construct1()
    {
        $this->bookings = new ArrayCollection();
       
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVol(): ?string
    {
        return $this->nomVol;
    }

    public function setNomVol(string $nomVol): self
    {
        $this->nomVol = $nomVol;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
     public function getRestaurant(): ?restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }


    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setVol($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getVol() === $this) {
                $billet->setVol(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nomVol;
    }
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }
}
