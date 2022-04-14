<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity(repositoryClass="App\Repository\HebergementRepository")
 */

class Hebergement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_hbg", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHbg;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")

     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="date", nullable=false)
     */
    private $dateAjout;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=false)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_hotel", type="string", length=30, nullable=false)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $nomHotel;

    /**
     * @var int
     * @Assert\PositiveOrZero
     * @ORM\Column(name="nb_chambres", type="integer", nullable=false)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $nbChambres;

    /**
     * @var int
     * @Assert\PositiveOrZero
     * @ORM\Column(name="nb_suites", type="integer", nullable=false)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $nbSuites;

    /**
     * @var int
     *  @Assert\PositiveOrZero
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     * @ORM\Column(name="piscine", type="integer", nullable=false)
     */
    private $piscine;

    /**
     * @var string|null
     * 
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int
     * @Assert\PositiveOrZero
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    public function getIdHbg(): ?int
    {
        return $this->idHbg;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getNomHotel(): ?string
    {
        return $this->nomHotel;
    }

    public function setNomHotel(string $nomHotel): self
    {
        $this->nomHotel = $nomHotel;

        return $this;
    }

    public function getNbChambres(): ?int
    {
        return $this->nbChambres;
    }

    public function setNbChambres(int $nbChambres): self
    {
        $this->nbChambres = $nbChambres;

        return $this;
    }

    public function getNbSuites(): ?int
    {
        return $this->nbSuites;
    }

    public function setNbSuites(int $nbSuites): self
    {
        $this->nbSuites = $nbSuites;

        return $this;
    }

    public function getPiscine(): ?int
    {
        return $this->piscine;
    }

    public function setPiscine(int $piscine): self
    {
        $this->piscine = $piscine;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
