<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voyageorganise
 *
 * @ORM\Table(name="voyageorganise")
 * @ORM\Entity
 */
class Voyageorganise
{
    /**
     * @var int
     *
     * @ORM\Column(name="idvoyageorganise", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvoyageorganise;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedepart", type="date", nullable=false)
     */
    private $datedepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateretour", type="date", nullable=false)
     */
    private $dateretour;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="guide", type="string", length=255, nullable=false)
     */
    private $guide;

    /**
     * @var int
     *
     * @ORM\Column(name="image", type="integer", nullable=false)
     */
    private $image;


}
