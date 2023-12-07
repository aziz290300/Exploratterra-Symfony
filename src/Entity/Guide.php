<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Guide
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank
     */
    private ?string $prenom = null;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     */
    private ?string $nom = null;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank
     */
    private ?string $langueParle = null;

    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank
     */
    private ?string $disponiblite = null;
    /**
     * @ORM\Column(length=255)
     * @Assert\NotBlank
     */
    private ?string $email = null;

    /**
     * @ORM\OneToMany(mappedBy="guide", targetEntity="Voyage")
     */
    private Collection $Voyagess;

    public function __construct()
    {
        $this->Voyagess = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function __toString()
    {
        return (string) $this-> getPrenom();
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLangueParle(): ?string
    {
        return $this->langueParle;
    }

    public function setLangueParle(string $langueParle): static
    {
        $this->langueParle = $langueParle;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDisponiblite(): ?string
    {
        return $this->disponiblite;
    }

    public function setDisponiblite(?string $disponiblite): void
    {
        $this->disponiblite = $disponiblite;
    }

    /**
     * @return Collection<int, Voyage>
     */
    public function getVoyagess(): Collection
    {
        return $this->Voyagess;
    }

    public function addVoyagess(Voyage $voyagess): static
    {
        if (!$this->Voyagess->contains($voyagess)) {
            $this->Voyagess->add($voyagess);
            $voyagess->setGuide($this);
        }

        return $this;
    }

    public function removeVoyagess(Voyage $voyagess): static
    {
        if ($this->Voyagess->removeElement($voyagess)) {
            // set the owning side to null (unless already changed)
            if ($voyagess->getGuide() === $this) {
                $voyagess->setGuide(null);
            }
        }

        return $this;
    }


}
