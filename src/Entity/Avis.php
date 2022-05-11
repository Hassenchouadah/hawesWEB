<?php

namespace App\Entity;


use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Utilisateur;

/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="idUser", columns={"idUser"})})
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
     * @Groups("post:read")

     */
    private $idAvis;

    /**
     * @var string
          * @Assert\NotBlank(message="description is required")
     * @Assert\Length(min="8", maxMessage="le nom doit depasser 8 caractéres")

     * @ORM\Column(name="desc_avis", type="string", length=3000, nullable=false)
     * @Groups("post:read")
     */
    private $descAvis;

    /**
     * @var int
     *
     * @Groups("post:read")
     * @ORM\Column(name="etoile", type="integer", nullable=false)
     */
    private $etoile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjoutavis", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
    * @Groups("post:read")
     */
    private $dateajoutavis = 'CURRENT_TIMESTAMP';

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @Groups("post:read")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

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

    public function getIduser(): ?Utilisateur
    {
        return $this->iduser;
    }

    public function setIduser(?Utilisateur $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
