<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Utilisateur;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="type_id", columns={"type_id"}), @ORM\Index(name="idUser", columns={"idUser"})})
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
     * @Groups("post:read")
     */
    private $idRec;

   /**
     * @var string
     * @Assert\NotBlank(message="description is required")
     * @Assert\Length(min="8", maxMessage="le nom doit depasser 8 caractéres")
     * @ORM\Column(name="desc_rec", type="string", length=3000, nullable=false)
      *@Groups("post:read")
     */
    private $descRec;

    /**
     * @var int
     * @Groups("post:read")
     * @ORM\Column(name="traite", type="integer", nullable=false)
     */
    private $traite = '0';

    /**
     * @var \DateTime
     * @Groups("post:read")
     * @ORM\Column(name="dateAjoutrec", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateajoutrec = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     * @Groups("post:read")
     * @ORM\Column(name="dateTraitrec", type="datetime", nullable=true)
     */

    private $datetraitrec;

    /**
     * @var \Utilisateur
     * @Groups("post:read")
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Type
     * @Groups("post:read")
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;
    
    public function setIdRec(int $idRec): self
    {
        $this->idRec = $idRec;

        return $this;
    }
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

    public function getIduser(): ?Utilisateur
    {
        return $this->iduser;
    }

    public function setIduser(?Utilisateur $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }


}
