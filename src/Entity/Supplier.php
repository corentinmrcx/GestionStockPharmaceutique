<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom du fournisseur est obligatoire.')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Le nom du fournisseur ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'L\'adresse ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $address = null;

    #[ORM\Column(length: 10)]
    #[Assert\Length(
        max: 10,
        maxMessage: 'Le code postal ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^\d{5}$/',
        message: 'Le code postal doit contenir exactement 5 chiffres.'
    )]
    private ?string $postalCode = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La ville ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $city = null;

    #[ORM\Column(length: 25)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone est obligatoire.')]
    #[Assert\Length(
        max: 25,
        maxMessage: 'Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^\+?[0-9\s\-]{10,25}$/',
        message: 'Le numéro de téléphone n\'est pas valide.'
    )]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'email est obligatoire.')]
    #[Assert\Email(message: 'L\'email {{ value }} n\'est pas un email valide.')]
    private ?string $email = null;

    /**
     * @var Collection<int, Supply>
     */
    #[ORM\OneToMany(targetEntity: Supply::class, mappedBy: 'supplier')]
    private Collection $supplies;

    public function __construct()
    {
        $this->supplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdSupplier(int $idSupplier): static
    {
        $this->id = $idSupplier;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

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
            $supply->setSupplier($this);
        }

        return $this;
    }

    public function removeSupply(Supply $supply): static
    {
        if ($this->supplies->removeElement($supply)) {
            // set the owning side to null (unless already changed)
            if ($supply->getSupplier() === $this) {
                $supply->setSupplier(null);
            }
        }

        return $this;
    }
}