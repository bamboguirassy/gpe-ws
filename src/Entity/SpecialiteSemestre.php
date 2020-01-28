<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialiteSemestre
 *
 * @ORM\Table(name="specialite_semestre", indexes={@ORM\Index(name="semestre", columns={"semestre", "specialite"}), @ORM\Index(name="specialite", columns={"specialite"})})
 * @ORM\Entity
 */
class SpecialiteSemestre
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
     * @var int
     *
     * @ORM\Column(name="semestre", type="integer", nullable=false)
     */
    private $semestre;

    /**
     * @var int
     *
     * @ORM\Column(name="specialite", type="integer", nullable=false)
     */
    private $specialite;


}
