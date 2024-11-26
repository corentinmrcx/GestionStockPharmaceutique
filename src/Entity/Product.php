<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduct = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?array $images = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expirationDate = null;

    #[ORM\ManyToOne(targetEntity: 'Category', inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: 'Stock', inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stock $stock = null;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $orderLines;

    /**
     * @var Collection<int, SupplyLine>
     */
    #[ORM\OneToMany(targetEntity: SupplyLine::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $supplyLines;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
        $this->supplyLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(int $idProduct): static
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeImmutable $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->setProduct($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getProduct() === $this) {
                $orderLine->setProduct(null);
            }
        }

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
            $supplyLine->setProduct($this);
        }

        return $this;
    }

    public function removeSupplyLine(SupplyLine $supplyLine): static
    {
        if ($this->supplyLines->removeElement($supplyLine)) {
            // set the owning side to null (unless already changed)
            if ($supplyLine->getProduct() === $this) {
                $supplyLine->setProduct(null);
            }
        }

        return $this;
    }
}