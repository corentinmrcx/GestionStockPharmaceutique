<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $inventoryDate = null;

    #[ORM\ManyToOne(targetEntity: Stock::class, inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

    #[ORM\ManyToOne(inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $administrator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdInventory(int $idInventory): static
    {
        $this->id = $idInventory;

        return $this;
    }

    public function getInventoryDate(): ?\DateTimeImmutable
    {
        return $this->inventoryDate;
    }

    public function setInventoryDate(\DateTimeImmutable $inventoryDate): static
    {
        $this->inventoryDate = $inventoryDate;

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

    public function getAdministrator(): ?User
    {
        return $this->administrator;
    }

    public function setAdministrator(?User $administrator): static
    {
        $this->administrator = $administrator;

        return $this;
    }
}
