<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="id_hbg", columns={"id_hbg"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_avis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAvis;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_avis", type="string", length=3000, nullable=false)
     */
    private $descAvis;

    /**
     * @var int
     *
     * @ORM\Column(name="etoile", type="integer", nullable=false)
     */
    private $etoile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoutavis", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $dateajoutavis = 'current_timestamp()';

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

    public function getIdAvis(): ?int
    {
        return $this->idAvis;
    }

    public function getDescAvis(): ?string
    {
        return $this->descAvis;
    }

    public function setDescAvis(string $descAvis): self
    {
        $this->descAvis = $descAvis;

        return $this;
    }

    public function getEtoile(): ?int
    {
        return $this->etoile;
    }

    public function setEtoile(int $etoile): self
    {
        $this->etoile = $etoile;

        return $this;
    }

    public function getDateajoutavis(): ?\DateTimeInterface
    {
        return $this->dateajoutavis;
    }

    public function setDateajoutavis(\DateTimeInterface $dateajoutavis): self
    {
        $this->dateajoutavis = $dateajoutavis;

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
