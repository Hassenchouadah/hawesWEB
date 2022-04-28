<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="FK_42C84955FE6E88D7", columns={"idUser"}), @ORM\Index(name="FK_42C84955BF74E90", columns={"idHebr"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idres;

    /**
     * @var int
     *
     * @ORM\Column(name="idVol", type="integer", nullable=false)
     */
    private $idvol;

    /**
     * @var int|null
     *
     * @ORM\Column(name="valide", type="integer", nullable=true)
     */
    private $valide;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPersonne", type="integer", nullable=false)
     */
    private $nbpersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="forfait", type="string", length=25, nullable=false)
     */
    private $forfait;

    /**
     * @var int
     *
     * @ORM\Column(name="nbChambre", type="integer", nullable=false)
     */
    private $nbchambre;

    /**
     * @var int
     *
     * @ORM\Column(name="nbSuite", type="integer", nullable=false)
     */
    private $nbsuite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateArr", type="date", nullable=false)
     */
    private $datearr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDep", type="date", nullable=false)
     */
    private $datedep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRes", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateres = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadlineAnnulation", type="datetime", nullable=false)
     */
    private $deadlineannulation;

    /**
     * @var \Utilisateurs
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

    /**
     * @var \Hebergement
     *
     * @ORM\ManyToOne(targetEntity="Hebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idHebr", referencedColumnName="id_hbg")
     * })
     */
    private $idhebr;

    public function getIdres(): ?int
    {
        return $this->idres;
    }

    public function getIdvol(): ?int
    {
        return $this->idvol;
    }

    public function setIdvol(int $idvol): self
    {
        $this->idvol = $idvol;

        return $this;
    }

    public function getValide(): ?int
    {
        return $this->valide;
    }

    public function setValide(?int $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getNbpersonne(): ?int
    {
        return $this->nbpersonne;
    }

    public function setNbpersonne(int $nbpersonne): self
    {
        $this->nbpersonne = $nbpersonne;

        return $this;
    }

    public function getForfait(): ?string
    {
        return $this->forfait;
    }

    public function setForfait(string $forfait): self
    {
        $this->forfait = $forfait;

        return $this;
    }

    public function getNbchambre(): ?int
    {
        return $this->nbchambre;
    }

    public function setNbchambre(int $nbchambre): self
    {
        $this->nbchambre = $nbchambre;

        return $this;
    }

    public function getNbsuite(): ?int
    {
        return $this->nbsuite;
    }

    public function setNbsuite(int $nbsuite): self
    {
        $this->nbsuite = $nbsuite;

        return $this;
    }

    public function getDatearr(): ?\DateTimeInterface
    {
        return $this->datearr;
    }

    public function setDatearr(\DateTimeInterface $datearr): self
    {
        $this->datearr = $datearr;

        return $this;
    }

    public function getDatedep(): ?\DateTimeInterface
    {
        return $this->datedep;
    }

    public function setDatedep(\DateTimeInterface $datedep): self
    {
        $this->datedep = $datedep;

        return $this;
    }

    public function getDateres(): ?\DateTimeInterface
    {
        return $this->dateres;
    }

    public function setDateres(\DateTimeInterface $dateres): self
    {
        $this->dateres = $dateres;

        return $this;
    }

    public function getDeadlineannulation(): ?\DateTimeInterface
    {
        return $this->deadlineannulation;
    }

    public function setDeadlineannulation(\DateTimeInterface $deadlineannulation): self
    {
        $this->deadlineannulation = $deadlineannulation;

        return $this;
    }

    public function getIduser(): ?Utilisateurs
    {
        return $this->iduser;
    }

    public function setIduser(?Utilisateurs $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdhebr(): ?Hebergement
    {
        return $this->idhebr;
    }

    public function setIdhebr(?Hebergement $idhebr): self
    {
        $this->idhebr = $idhebr;

        return $this;
    }


}
