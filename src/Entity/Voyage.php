<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="VoyageRepository")
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $destination;

    /**
     * @ORM\Column
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Type(type="\DateTimeInterface")
     */
    private $date_depart;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $placeDisponible;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Type(type="\DateTimeInterface")
     */
    private $date_retour;

    /**
     * @ORM\ManyToOne(inversedBy="Voyagess",targetEntity="Guide")
     */
    private $guide;

    /**
     * @ORM\Column(length=255)
     */
    private $image;

    /**
     * @ORM\Column(length=255)
     * @Assert\Type(type="string")
     */
    private $itineraire;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): static
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    

   

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTimeInterface $date_retour): static
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): void
    {
        $this->prix = $prix;
    }

    public function getPlaceDisponible(): int
    {
        return $this->placeDisponible;
    }

    public function setPlaceDisponible(int $placeDisponible): void
    {
        $this->placeDisponible = $placeDisponible;
    }

    public function getGuide(): ?Guide
    {
        return $this->guide;
    }

    public function setGuide(?Guide $guide): static
    {
        $this->guide = $guide;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getItineraire(): ?string
    {
        return $this->itineraire;
    }

    public function setItineraire(string $itineraire): static
    {
        $this->itineraire = $itineraire;

        return $this;
    }



}
