<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=8, nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nomUser", type="string", length=255, nullable=false)
     */
    private $nomuser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomUser", type="string", length=255, nullable=false)
     */
    private $prenomuser;

    /**
     * @var string
     *
     * @ORM\Column(name="telUser", type="string", length=25, nullable=false)
     */
    private $teluser;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseUser", type="string", length=255, nullable=false)
     */
    private $adresseuser;

    /**
     * @var string
     *
     * @ORM\Column(name="mdpUser", type="string", length=255, nullable=false)
     */
    private $mdpuser;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=25, nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUser", type="string", length=255, nullable=false)
     */
    private $emailuser;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(string $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    public function getPrenomuser(): ?string
    {
        return $this->prenomuser;
    }

    public function setPrenomuser(string $prenomuser): self
    {
        $this->prenomuser = $prenomuser;

        return $this;
    }

    public function getTeluser(): ?string
    {
        return $this->teluser;
    }

    public function setTeluser(string $teluser): self
    {
        $this->teluser = $teluser;

        return $this;
    }

    public function getAdresseuser(): ?string
    {
        return $this->adresseuser;
    }

    public function setAdresseuser(string $adresseuser): self
    {
        $this->adresseuser = $adresseuser;

        return $this;
    }

    public function getMdpuser(): ?string
    {
        return $this->mdpuser;
    }

    public function setMdpuser(string $mdpuser): self
    {
        $this->mdpuser = $mdpuser;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEmailuser(): ?string
    {
        return $this->emailuser;
    }

    public function setEmailuser(string $emailuser): self
    {
        $this->emailuser = $emailuser;

        return $this;
    }
    public function __toString() {
        return $this->iduser;
    }

}
