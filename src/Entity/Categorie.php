<?php

namespace App\Entity;
use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Evenement;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrer le nom")
     * @Assert\Regex(
     *     pattern="/^\D+$/",
     *     message="The name cannot contain numbers."
     * )
     */
    private ?string $nom = null;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="categorie")
     */    
    private $events;


    public function getId(): ?int
    {
        return $this->id;
    }

   

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
    public function __toString(): string 
    {
        return $this->getNom();
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function setEvents(null$events): self
    {
        $this->events = $events;

        return $this;
    }
}
