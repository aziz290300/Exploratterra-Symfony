<?php

namespace App\Entity;

use App\Repository\BookingVolRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingVolRepository::class)
 */
class BookingVol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Vol::class, inversedBy="bookings")
     * @ORM\JoinColumn(name="vol_id", referencedColumnName="id", nullable=false)
     */
    private $volB;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre;

    // Additional properties or methods can be added here

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolB(): ?Vol
    {
        return $this->volB;
    }

    public function setVolB(?Vol $volB): self
    {
        $this->volB = $volB;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

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

    // Additional getters and setters can be added here
}
