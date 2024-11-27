<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(targetEntity: Stock::class, inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

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
