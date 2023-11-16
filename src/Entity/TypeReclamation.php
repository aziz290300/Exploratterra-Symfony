<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeReclamation
 *
 * @ORM\Table(name="type_reclamation")
 * @ORM\Entity
 */
class TypeReclamation
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
     * @ORM\Column(name="typereclamation", type="string", length=255, nullable=false)
     */
    private $typereclamation;


}
