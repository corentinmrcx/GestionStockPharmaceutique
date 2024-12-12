<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?array $images = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\GreaterThanOrEqual("today")]
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

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?bool $isRecommended = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    /**
     * @var Collection<int, CartLine>
     */
    #[ORM\OneToMany(targetEntity: CartLine::class, mappedBy: 'product')]
    private Collection $cartLine;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
        $this->supplyLines = new ArrayCollection();
        $this->cartLine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdProduct(int $idProduct): static
    {
        $this->id = $idProduct;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function isRecommended(): ?bool
    {
        return $this->isRecommended;
    }

    public function setIsRecommended(bool $isRecommended): static
    {
        $this->isRecommended = $isRecommended;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, CartLine>
     */
    public function getCartLine(): Collection
    {
        return $this->cartLine;
    }

    public function addCartLine(CartLine $cartLine): static
    {
        if (!$this->cartLine->contains($cartLine)) {
            $this->cartLine->add($cartLine);
            $cartLine->setProduct($this);
        }

        return $this;
    }

    public function removeCartLine(CartLine $cartLine): static
    {
        if ($this->cartLine->removeElement($cartLine)) {
            // set the owning side to null (unless already changed)
            if ($cartLine->getProduct() === $this) {
                $cartLine->setProduct(null);
            }
        }

        return $this;
    }
}
