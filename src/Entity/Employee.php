<?php

namespace App\Entity;

use App\enum\EmpType;
use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 25)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?EmpType $role = null;

    /**
     * @var Collection<int, Inventory>
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'employee', orphanRemoval: true)]
    private Collection $inventories;

    /**
     * @var Collection<int, Delivery>
     */
    #[ORM\OneToMany(targetEntity: Delivery::class, mappedBy: 'employee', orphanRemoval: true)]
    private Collection $deliveries;

    /**
     * @var Collection<int, Supply>
     */
    #[ORM\OneToMany(targetEntity: Supply::class, mappedBy: 'employee', orphanRemoval: true)]
    private Collection $supplies;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
        $this->supplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdEmployee(int $idEmployee): static
    {
        $this->id = $idEmployee;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?EmpType
    {
        return $this->role;
    }

    public function setRole(EmpType $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): static
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories->add($inventory);
            $inventory->setEmployee($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): static
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getEmployee() === $this) {
                $inventory->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->setEmployee($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getEmployee() === $this) {
                $delivery->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Supply>
     */
    public function getSupplies(): Collection
    {
        return $this->supplies;
    }

    public function addSupply(Supply $supply): static
    {
        if (!$this->supplies->contains($supply)) {
            $this->supplies->add($supply);
            $supply->setEmployee($this);
        }

        return $this;
    }

    public function removeSupply(Supply $supply): static
    {
        if ($this->supplies->removeElement($supply)) {
            // set the owning side to null (unless already changed)
            if ($supply->getEmployee() === $this) {
                $supply->setEmployee(null);
            }
        }

        return $this;
    }
}
