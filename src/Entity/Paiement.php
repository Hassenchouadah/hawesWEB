<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="idRes", columns={"idRes"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaiementRepository")
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPmt", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpmt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePmt", type="datetime", nullable=false)
     */
    private $datepmt;

    /**
     * @var string
     *
     * @ORM\Column(name="methode", type="string", length=30, nullable=false)
     */
    private $methode;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Positive
     * @Assert\Type(type="float", message="Die Kistenanzahl muss eine Zahl sein.")
     */
    private $montant;

    /**
     * @var int
     * @ORM\Column(name="canceled", type="integer", nullable=false)
     */
    private $canceled = '0';

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRes", referencedColumnName="idRes")
     * })
     */
    private $idres;

    public function getIdpmt(): ?int
    {
        return $this->idpmt;
    }

    public function getDatepmt(): ?\DateTimeInterface
    {
        return $this->datepmt;
    }

    public function setDatepmt(\DateTimeInterface $datepmt): self
    {
        $this->datepmt = $datepmt;

        return $this;
    }

    public function getMethode(): ?string
    {
        return $this->methode;
    }

    public function setMethode(string $methode): self
    {
        $this->methode = $methode;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCanceled(): ?int
    {
        return $this->canceled;
    }

    public function setCanceled(int $canceled): self
    {
        $this->canceled = $canceled;

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

    public function __toString() {
        return (String) $this->idpmt;
    }
}
