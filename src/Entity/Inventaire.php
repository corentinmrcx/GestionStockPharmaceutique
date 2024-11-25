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

    /**
     * @var Collection<int, Employe>
     */
    #[ORM\ManyToMany(targetEntity: Employe::class, inversedBy: 'inventaires')]
    private Collection $employe;

    public function __construct()
    {
        $this->employe = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Employe>
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employe->contains($employe)) {
            $this->employe->add($employe);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): static
    {
        $this->employe->removeElement($employe);

        return $this;
    }
}
