<?php

namespace App\Entity;

use App\Repository\SupplyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplyRepository::class)]
class Supply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $supplyDate = null;

    #[ORM\ManyToOne(targetEntity: Supplier::class, inversedBy: 'supplies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier = null;

    /**
     * @var Collection<int, SupplyLine>
     */
    #[ORM\OneToMany(targetEntity: SupplyLine::class, mappedBy: 'supply', orphanRemoval: true)]
    private Collection $supplyLines;

    #[ORM\ManyToOne(inversedBy: 'supplies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $manager = null;

    public function __construct()
    {
        $this->supplyLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplyDate(): ?\DateTimeImmutable
    {
        return $this->supplyDate;
    }

    public function setSupplyDate(\DateTimeImmutable $supplyDate): static
    {
        $this->supplyDate = $supplyDate;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * @return Collection<int, SupplyLine>
     */
    public function getSupplyLines(): Collection
    {
        return $this->supplyLines;
    }

    public function addSupplyLine(SupplyLine $supplyLine): static
    {
        if (!$this->supplyLines->contains($supplyLine)) {
            $this->supplyLines->add($supplyLine);
            $supplyLine->setSupply($this);
        }

        return $this;
    }

    public function removeSupplyLine(SupplyLine $supplyLine): static
    {
        if ($this->supplyLines->removeElement($supplyLine)) {
            // set the owning side to null (unless already changed)
            if ($supplyLine->getSupply() === $this) {
                $supplyLine->setSupply(null);
            }
        }

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): static
    {
        $this->manager = $manager;

        return $this;
    }
}
