<?php

namespace App\Entity;

use App\Entity\Destination;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConseillerRepository;

#[ORM\Entity(repositoryClass: ConseillerRepository::class)]
class Conseiller extends User
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'boolean')]
    private $referent;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $maj;

    #[ORM\ManyToOne(targetEntity: Destination::class, inversedBy: 'conseillers')]
    private $specialite;

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getReferent(): ?bool
    {
        return $this->referent;
    }

    public function setReferent(bool $referent): self
    {
        $this->referent = $referent;

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

    public function getMaj(): ?\DateTimeInterface
    {
        return $this->maj;
    }

    public function setMaj(\DateTimeInterface $maj): self
    {
        $this->maj = $maj;

        return $this;
    }

    public function getSpecialite(): ?Destination
    {
        return $this->specialite;
    }

    public function setSpecialite(?Destination $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }
}
