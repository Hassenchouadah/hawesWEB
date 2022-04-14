<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="etoile", type="integer", nullable=false)
     */
    private $etoile;

    /**
     * @var \Thebergement
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Thebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hbg", referencedColumnName="id_hbg")
     * })
     */
    private $idHbg;

    public function getEtoile(): ?int
    {
        return $this->etoile;
    }

    public function setEtoile(int $etoile): self
    {
        $this->etoile = $etoile;

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
