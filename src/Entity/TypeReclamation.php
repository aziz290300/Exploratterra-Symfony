<?php

// src/Entity/TypeReclamation.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TypeReclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="libelle_type_reclamation")
     */
    private $libelleTypeReclamation;

    // ... existing getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTypeReclamation(): ?string
    {
        return $this->libelleTypeReclamation;
    }

    public function setLibelleTypeReclamation(string $libelleTypeReclamation): self
    {
        $this->libelleTypeReclamation = $libelleTypeReclamation;

        return $this;
    }
    public function __toString(): string
    {
        return $this->libelleTypeReclamation;
    }
}
