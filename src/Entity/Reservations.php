<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations", indexes={@ORM\Index(name="fk_participant_reservation", columns={"participant_id"}), @ORM\Index(name="fk_evenement_reservation", columns={"evenement_id"})})
 * @ORM\Entity
 */
class Reservations
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
     * @var int|null
     *
     * @ORM\Column(name="places_reservees", type="integer", nullable=true)
     */
    private $placesReservees;

    /**
     * @var int|null
     *
     * @ORM\Column(name="participant_id", type="integer", nullable=true)
     */
    private $participantId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateheure_reservation", type="datetime", nullable=true)
     */
    private $dateheureReservation;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="validate", type="boolean", nullable=true)
     */
    private $validate = '0';

    /**
     * @var \Evenements
     *
     * @ORM\ManyToOne(targetEntity="Evenements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     * })
     */
    private $evenement;


}
