<?php

// src/Entity/Billet.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Billet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="nom_billet")
     */
    private $nomBillet;

    /**
     * @ORM\ManyToOne(targetEntity="Vol", inversedBy="billets")
     * @ORM\JoinColumn(name="vol_id", referencedColumnName="id", nullable=false)
     */
    private $vol;
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBillet(): ?string
    {
        return $this->nomBillet;
    }

    public function setNomBillet(string $nomBillet): self
    {
        $this->nomBillet = $nomBillet;

        return $this;
    }

    public function getVol(): ?Vol
    {
        return $this->vol;
    }

    public function setVol(?Vol $vol): self
    {
        $this->vol = $vol;

        return $this;
    }
    public function setQrCode(string $qrCode): void
    {
        $this->qrCode = $qrCode;
    }
   
}
