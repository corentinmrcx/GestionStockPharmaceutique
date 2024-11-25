<?php

namespace App\Entity;

use App\Repository\ApprovisionnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApprovisionnementRepository::class)]
class Approvisionnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idAppr = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateAppr = null;

    #[ORM\ManyToOne(targetEntity: "Fournisseur", inversedBy: 'approvisionnement')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    /**
     * @var Collection<int, LigneApprovisionnement>
     */
    #[ORM\OneToMany(targetEntity: LigneApprovisionnement::class, mappedBy: 'approvisionnement', orphanRemoval: true)]
    private Collection $ligneApprovisionnement;

    public function __construct()
    {
        $this->ligneApprovisionnement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idAppr;
    }

    public function getDateAppr(): ?\DateTimeImmutable
    {
        return $this->dateAppr;
    }

    public function setDateAppr(\DateTimeImmutable $dateAppr): static
    {
        $this->dateAppr = $dateAppr;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, LigneApprovisionnement>
     */
    public function getLigneApprovisionnement(): Collection
    {
        return $this->ligneApprovisionnement;
    }

    public function addLigneApprovisionnement(LigneApprovisionnement $ligneApprovisionnement): static
    {
        if (!$this->ligneApprovisionnement->contains($ligneApprovisionnement)) {
            $this->ligneApprovisionnement->add($ligneApprovisionnement);
            $ligneApprovisionnement->setApprovisionnement($this);
        }

        return $this;
    }

    public function removeLigneApprovisionnement(LigneApprovisionnement $ligneApprovisionnement): static
    {
        if ($this->ligneApprovisionnement->removeElement($ligneApprovisionnement)) {
            // set the owning side to null (unless already changed)
            if ($ligneApprovisionnement->getApprovisionnement() === $this) {
                $ligneApprovisionnement->setApprovisionnement(null);
            }
        }

        return $this;
    }
}
