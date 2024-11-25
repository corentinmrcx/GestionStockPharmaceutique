<?php

namespace App\Entity;

use App\Repository\InventaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventaireRepository::class)]
class Inventaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idInventaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateInventaire = null;

    #[ORM\ManyToOne(targetEntity: 'Employe', inversedBy: 'inventaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employe $employe = null;

    #[ORM\ManyToOne(targetEntity: 'Stock', inversedBy: 'inventaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

    public function getId(): ?int
    {
        return $this->idInventaire;
    }

    public function getDateInventaire(): ?\DateTimeImmutable
    {
        return $this->dateInventaire;
    }

    public function setDateInventaire(\DateTimeImmutable $dateInventaire): static
    {
        $this->dateInventaire = $dateInventaire;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): static
    {
        $this->employe = $employe;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
