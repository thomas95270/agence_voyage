<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EtapeRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EtapeRepository::class)]
/**
 * @Vich\Uploadable
 */
class Etape
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255)]
    private $photo;

    /**
     * @Vich\UploadableField(mapping="photo", fileNameProperty="photo" )
     */
    private $photoFile;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $maj;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $hotel;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'etapes', cascade:["persist"])]
    private $produit;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getMaj(): ?\DateTimeInterface
    {
        return $this->maj;
    }

    public function setMaj(?\DateTimeInterface $maj): self
    {
        $this->maj = $maj;

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

    public function getHotel(): ?string
    {
        return $this->hotel;
    }

    public function setHotel(string $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get the value of photoFile
     */ 
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * Set the value of photoFile
     *
     * @return  self
     */ 
    public function setPhotoFile($photoFile)
    {
        $this->photoFile = $photoFile;

        return $this;
    }
}
