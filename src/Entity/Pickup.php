<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pickup
 *
 * @ORM\Table(name="pickup")
 * @ORM\Entity
 */
class Pickup
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
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseDepart", type="string", length=50, nullable=false)
     */
    private $adressedepart;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseArrivee", type="string", length=50, nullable=false)
     */
    private $adressearrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="heureDepart", type="string", length=50, nullable=false)
     */
    private $heuredepart;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=10, nullable=false)
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getAdressedepart(): ?string
    {
        return $this->adressedepart;
    }

    public function setAdressedepart(string $adressedepart): self
    {
        $this->adressedepart = $adressedepart;

        return $this;
    }

    public function getAdressearrivee(): ?string
    {
        return $this->adressearrivee;
    }

    public function setAdressearrivee(string $adressearrivee): self
    {
        $this->adressearrivee = $adressearrivee;

        return $this;
    }

    public function getHeuredepart(): ?string
    {
        return $this->heuredepart;
    }

    public function setHeuredepart(string $heuredepart): self
    {
        $this->heuredepart = $heuredepart;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
