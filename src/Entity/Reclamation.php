<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="id_hbg", columns={"id_hbg"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_rec", type="string", length=3000, nullable=false)
     */
    private $descRec;

    /**
     * @var int
     *
     * @ORM\Column(name="traite", type="integer", nullable=false)
     */
    private $traite = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoutrec", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $dateajoutrec = 'current_timestamp()';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateTraitrec", type="datetime", nullable=true, options={"default"="current_timestamp()"})
     */
    private $datetraitrec = 'current_timestamp()';

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
     * @var \Thebergement
     *
     * @ORM\ManyToOne(targetEntity="Thebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hbg", referencedColumnName="id_hbg")
     * })
     */
    private $idHbg;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getDescRec(): ?string
    {
        return $this->descRec;
    }

    public function setDescRec(string $descRec): self
    {
        $this->descRec = $descRec;

        return $this;
    }

    public function getTraite(): ?int
    {
        return $this->traite;
    }

    public function setTraite(int $traite): self
    {
        $this->traite = $traite;

        return $this;
    }

    public function getDateajoutrec(): ?\DateTimeInterface
    {
        return $this->dateajoutrec;
    }

    public function setDateajoutrec(\DateTimeInterface $dateajoutrec): self
    {
        $this->dateajoutrec = $dateajoutrec;

        return $this;
    }

    public function getDatetraitrec(): ?\DateTimeInterface
    {
        return $this->datetraitrec;
    }

    public function setDatetraitrec(?\DateTimeInterface $datetraitrec): self
    {
        $this->datetraitrec = $datetraitrec;

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

    public function getIdHbg(): ?Thebergement
    {
        return $this->idHbg;
    }

    public function setIdHbg(?Thebergement $idHbg): self
    {
        $this->idHbg = $idHbg;

        return $this;
    }


}
