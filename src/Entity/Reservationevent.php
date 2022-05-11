<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationevent
 *
 * @ORM\Table(name="reservationevent", indexes={@ORM\Index(name="idRes", columns={"idRes"})})
 * @ORM\Entity
 */
class Reservationevent
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=true)
     */
    private $idevent;

    /**
     * @var \Reservation
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRes", referencedColumnName="idRes")
     * })
     */
    private $idres;

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function setIdevent(?int $idevent): self
    {
        $this->idevent = $idevent;

        return $this;
    }

    public function getIdres(): ?Reservation
    {
        return $this->idres;
    }

    public function setIdres(?Reservation $idres): self
    {
        $this->idres = $idres;

        return $this;
    }


}
