<?php

namespace App\Entity;
use App\Repository\EvenementRepository;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

/**
 * @ORM\Entity
 */
class Evenement
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrer le nom de l evenement")
     * @Assert\Regex(
     *     pattern="/^\D+$/",
     *     message="The name cannot contain numbers."
     * )
     */
    private ?string $nom = null;

    
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank(message="Entrer la date")
     */
    private ?\DateTimeInterface $dateDebut = null;    


    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrer la description")
     * @Assert\Length(
     *     min=10,
     *     max=150,
     *     minMessage="The description must be at least {{ limit }} characters",
     *     maxMessage="The description cannot exceed {{ limit }} characters"
     * )
     */
    private ?string $description = null;



    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrer la lieu")
     * @Assert\Length(
     *     min=10,
     *     max=150,
     *     minMessage="The lieu must be at least {{ limit }} characters",
     *     maxMessage="The lieu cannot exceed {{ limit }} characters"
     * )
     */
    private ?string $lieu = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $image = null;


    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Entrer le tarif")
     */
    private ?float $tarif = null;


   /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Entrer le nombre des places dispo")
     */
    private ?int $placesDispo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Categorie $categorie = null;

    

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(?float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getPlacesDispo(): ?int
    {
        return $this->placesDispo;
    }

    public function setPlacesDispo(?int $placesDispo): self
    {
        $this->placesDispo = $placesDispo;

        return $this;
    }

   

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }
}
