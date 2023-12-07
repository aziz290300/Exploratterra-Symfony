<?php

// src/Entity/Reclamation.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="contenu_reclamation")
     */
    private $contenuReclamation;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     */
    private $objet;
       
    /**
     * @ORM\ManyToOne(targetEntity="TypeReclamation")
     * @ORM\JoinColumn(name="type_reclamation_id", referencedColumnName="id")
     */

    private $typeReclamation;

    // ... existing getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuReclamation(): ?string
    {
        return $this->contenuReclamation;
    }

    public function setContenuReclamation(string $contenuReclamation): self
    {
        $this->contenuReclamation = $contenuReclamation;

        return $this;
    }

    public function getTypeReclamation(): ?TypeReclamation
    {
        return $this->typeReclamation;
    }

    public function setTypeReclamation(?TypeReclamation $typeReclamation): self
    {
        $this->typeReclamation = $typeReclamation;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }
}
