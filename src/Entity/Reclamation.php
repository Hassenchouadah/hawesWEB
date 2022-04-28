<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="FK_CE606404FE6E88D7", columns={"idUser"}), @ORM\Index(name="id_hbg", columns={"id_hbg"})})
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
    private $traite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoutrec", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateajoutrec = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateTraitrec", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datetraitrec = 'CURRENT_TIMESTAMP';

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

    public function getIdHbg(): ?Hebergement
    {
        return $this->idHbg;
    }

    public function setIdHbg(?Hebergement $idHbg): self
    {
        $this->idHbg = $idHbg;

        return $this;
    }


}
