<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 */
class Vol
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
     * @var string
     *
     * @ORM\Column(name="compagnie", type="string", length=100, nullable=false)
     */
    private $compagnie;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=100, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDepart", type="date", nullable=false)
     */
    private $datedepart;

    /**
     * @var string
     *
     * @ORM\Column(name="heureDepart", type="string", length=20, nullable=false)
     */
    private $heuredepart;

    /**
     * @var string
     *
     * @ORM\Column(name="heureArrivee", type="string", length=20, nullable=false)
     */
    private $heurearrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="avion", type="string", length=50, nullable=false)
     */
    private $avion;

    /**
     * @var int
     *
     * @ORM\Column(name="places", type="integer", nullable=false)
     */
    private $places;

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

    public function getCompagnie(): ?string
    {
        return $this->compagnie;
    }

    public function setCompagnie(string $compagnie): self
    {
        $this->compagnie = $compagnie;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->datedepart;
    }

    public function setDatedepart(\DateTimeInterface $datedepart): self
    {
        $this->datedepart = $datedepart;

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

    public function getHeurearrivee(): ?string
    {
        return $this->heurearrivee;
    }

    public function setHeurearrivee(string $heurearrivee): self
    {
        $this->heurearrivee = $heurearrivee;

        return $this;
    }

    public function getAvion(): ?string
    {
        return $this->avion;
    }

    public function setAvion(string $avion): self
    {
        $this->avion = $avion;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

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
