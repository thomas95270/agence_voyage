<?php

namespace App\Entity;

use App\Entity\Conseiller;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DestinationRepository::class)]
class Destination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'specialite', targetEntity: Conseiller::class)]
    private $conseillers;

    #[ORM\ManyToMany(targetEntity: Produit::class, mappedBy: 'destinations', cascade:["persist"])]
    private $produits;

    public function __construct()
    {
        $this->conseillers = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Conseiller>
     */
    public function getConseillers(): Collection
    {
        return $this->conseillers;
    }

    public function addConseiller(Conseiller $conseiller): self
    {
        if (!$this->conseillers->contains($conseiller)) {
            $this->conseillers[] = $conseiller;
            $conseiller->setSpecialite($this);
        }

        return $this;
    }

    public function removeConseiller(Conseiller $conseiller): self
    {
        if ($this->conseillers->removeElement($conseiller)) {
            // set the owning side to null (unless already changed)
            if ($conseiller->getSpecialite() === $this) {
                $conseiller->setSpecialite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->addDestination($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeDestination($this);
        }

        return $this;
    }
}
