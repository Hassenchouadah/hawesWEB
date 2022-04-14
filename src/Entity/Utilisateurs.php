<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 */
class Utilisateurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="NSC is required")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Votre numero de telephone doit contenir exactement 8 chiffres",
     *      maxMessage = "Votre numero de telephone doit contenir exactement 8 chiffres"
     * )
     */
    private $cin;
 

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="NSC is required")
     */
     
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $prenomUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $telUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $adresseUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $mdpUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $emailUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $voiture;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="NSC is required")
     */
    private $isVerified;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="NSC is required")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getTelUser(): ?string
    {
        return $this->telUser;
    }

    public function setTelUser(string $telUser): self
    {
        $this->telUser = $telUser;

        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresseUser;
    }

    public function setAdresseUser(string $adresseUser): self
    {
        $this->adresseUser = $adresseUser;

        return $this;
    }

    public function getMdpUser(): ?string
    {
        return $this->mdpUser;
    }

    public function setMdpUser(string $mdpUser): self
    {
        $this->mdpUser = $mdpUser;

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

    public function getEmailUser(): ?string
    {
        return $this->emailUser;
    }

    public function setEmailUser(string $emailUser): self
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    public function getVoiture(): ?string
    {
        return $this->voiture;
    }

    public function setVoiture(string $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getIsVerified(): ?int
    {
        return $this->isVerified;
    }

    public function setIsVerified(int $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}