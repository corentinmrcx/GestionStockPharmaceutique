<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCmde = null;

    #[ORM\Column]
    private ?int $numCmde = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCmde = null;

    #[ORM\ManyToOne(inversedBy: 'commande')]
    private ?Client $client = null;

    /**
     * @var Collection<int, LigneCmde>
     */
    #[ORM\OneToMany(targetEntity: LigneCmde::class, mappedBy: 'commande', orphanRemoval: true)]
    private Collection $ligneCmde;

    public function __construct()
    {
        $this->ligneCmde = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idCmde;
    }

    public function getNumCmde(): ?int
    {
        return $this->numCmde;
    }

    public function setNumCmde(int $numCmde): static
    {
        $this->numCmde = $numCmde;

        return $this;
    }

    public function getDateCmde(): ?\DateTimeImmutable
    {
        return $this->dateCmde;
    }

    public function setDateCmde(\DateTimeImmutable $dateCmde): static
    {
        $this->dateCmde = $dateCmde;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, LigneCmde>
     */
    public function getLigneCmde(): Collection
    {
        return $this->ligneCmde;
    }

    public function addLigneCmde(LigneCmde $ligneCmde): static
    {
        if (!$this->ligneCmde->contains($ligneCmde)) {
            $this->ligneCmde->add($ligneCmde);
            $ligneCmde->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCmde(LigneCmde $ligneCmde): static
    {
        if ($this->ligneCmde->removeElement($ligneCmde)) {
            // set the owning side to null (unless already changed)
            if ($ligneCmde->getCommande() === $this) {
                $ligneCmde->setCommande(null);
            }
        }

        return $this;
    }
}
