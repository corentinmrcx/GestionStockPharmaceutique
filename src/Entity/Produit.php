<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProd = null;

    #[ORM\Column(length: 255)]
    private ?string $libProd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descProd = null;

    #[ORM\Column]
    private ?float $prixProd = null;

    #[ORM\Column(nullable: true)]
    private ?array $imgProd = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateExpiration = null;

    #[ORM\ManyToOne(targetEntity: 'Categorie', inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToOne(mappedBy: 'produit', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    /**
     * @var Collection<int, LigneCmde>
     */
    #[ORM\OneToMany(targetEntity: LigneCmde::class, mappedBy: 'produit', orphanRemoval: true)]
    private Collection $ligneCmdes;

    /**
     * @var Collection<int, LigneApprovisionnement>
     */
    #[ORM\OneToMany(targetEntity: LigneApprovisionnement::class, mappedBy: 'produit', orphanRemoval: true)]
    private Collection $ligneApprovisionnements;

    public function __construct()
    {
        $this->ligneCmdes = new ArrayCollection();
        $this->ligneApprovisionnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idProd;
    }

    public function setIdProd(int $idProd): static
    {
        $this->idProd = $idProd;

        return $this;
    }

    public function getLibProd(): ?string
    {
        return $this->libProd;
    }

    public function setLibProd(string $libProd): static
    {
        $this->libProd = $libProd;

        return $this;
    }

    public function getDescProd(): ?string
    {
        return $this->descProd;
    }

    public function setDescProd(?string $descProd): static
    {
        $this->descProd = $descProd;

        return $this;
    }

    public function getPrixProd(): ?float
    {
        return $this->prixProd;
    }

    public function setPrixProd(float $prixProd): static
    {
        $this->prixProd = $prixProd;

        return $this;
    }

    public function getImgProd(): ?array
    {
        return $this->imgProd;
    }

    public function setImgProd(?array $imgProd): static
    {
        $this->imgProd = $imgProd;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeImmutable
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeImmutable $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): static
    {
        // set the owning side of the relation if necessary
        if ($stock->getProduit() !== $this) {
            $stock->setProduit($this);
        }

        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, LigneCmde>
     */
    public function getLigneCmdes(): Collection
    {
        return $this->ligneCmdes;
    }

    public function addLigneCmde(LigneCmde $ligneCmde): static
    {
        if (!$this->ligneCmdes->contains($ligneCmde)) {
            $this->ligneCmdes->add($ligneCmde);
            $ligneCmde->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCmde(LigneCmde $ligneCmde): static
    {
        if ($this->ligneCmdes->removeElement($ligneCmde)) {
            // set the owning side to null (unless already changed)
            if ($ligneCmde->getProduit() === $this) {
                $ligneCmde->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneApprovisionnement>
     */
    public function getLigneApprovisionnements(): Collection
    {
        return $this->ligneApprovisionnements;
    }

    public function addLigneApprovisionnement(LigneApprovisionnement $ligneApprovisionnement): static
    {
        if (!$this->ligneApprovisionnements->contains($ligneApprovisionnement)) {
            $this->ligneApprovisionnements->add($ligneApprovisionnement);
            $ligneApprovisionnement->setProduit($this);
        }

        return $this;
    }

    public function removeLigneApprovisionnement(LigneApprovisionnement $ligneApprovisionnement): static
    {
        if ($this->ligneApprovisionnements->removeElement($ligneApprovisionnement)) {
            // set the owning side to null (unless already changed)
            if ($ligneApprovisionnement->getProduit() === $this) {
                $ligneApprovisionnement->setProduit(null);
            }
        }

        return $this;
    }
}
