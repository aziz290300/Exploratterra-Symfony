<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 */
class Vol
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_vol", type="string", length=255, nullable=false)
     */
    private $numeroVol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_depart", type="date", nullable=false)
     */
    private $dateDepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_arrivee", type="date", nullable=false)
     */
    private $dateArrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_depart", type="string", length=255, nullable=false)
     */
    private $lieuDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_arrivee", type="string", length=255, nullable=false)
     */
    private $lieuArrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="compagnie_aerienne", type="string", length=255, nullable=false)
     */
    private $compagnieAerienne;


}
