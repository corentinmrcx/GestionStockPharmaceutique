<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idFour = null;

    #[ORM\Column(length: 100)]
    private ?string $libFour = null;

    #[ORM\Column(length: 255)]
    private ?string $adrFour = null;

    #[ORM\Column(length: 10)]
    private ?string $cpFour = null;

    #[ORM\Column(length: 50)]
    private ?string $villeFour = null;

    #[ORM\Column(length: 25)]
    private ?string $telFour = null;

    #[ORM\Column(length: 255)]
    private ?string $mailFour = null;

    /**
     * @var Collection<int, Approvisionnement>
     */
    #[ORM\OneToMany(targetEntity: Approvisionnement::class, mappedBy: 'fournisseur')]
    private Collection $approvisionnement;

    public function __construct()
    {
        $this->approvisionnement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idFour;
    }

    public function setIdFour(int $idFour): static
    {
        $this->idFour = $idFour;

        return $this;
    }

    public function getLibFour(): ?string
    {
        return $this->libFour;
    }

    public function setLibFour(string $libFour): static
    {
        $this->libFour = $libFour;

        return $this;
    }

    public function getAdrFour(): ?string
    {
        return $this->adrFour;
    }

    public function setAdrFour(string $adrFour): static
    {
        $this->adrFour = $adrFour;

        return $this;
    }

    public function getCpFour(): ?string
    {
        return $this->cpFour;
    }

    public function setCpFour(string $cpFour): static
    {
        $this->cpFour = $cpFour;

        return $this;
    }

    public function getVilleFour(): ?string
    {
        return $this->villeFour;
    }

    public function setVilleFour(string $villeFour): static
    {
        $this->villeFour = $villeFour;

        return $this;
    }

    public function getTelFour(): ?string
    {
        return $this->telFour;
    }

    public function setTelFour(string $telFour): static
    {
        $this->telFour = $telFour;

        return $this;
    }

    public function getMailFour(): ?string
    {
        return $this->mailFour;
    }

    public function setMailFour(string $mailFour): static
    {
        $this->mailFour = $mailFour;

        return $this;
    }

    /**
     * @return Collection<int, Approvisionnement>
     */
    public function getApprovisionnement(): Collection
    {
        return $this->approvisionnement;
    }

    public function addApprovisionnement(Approvisionnement $approvisionnement): static
    {
        if (!$this->approvisionnement->contains($approvisionnement)) {
            $this->approvisionnement->add($approvisionnement);
            $approvisionnement->setFournisseur($this);
        }

        return $this;
    }

    public function removeApprovisionnement(Approvisionnement $approvisionnement): static
    {
        if ($this->approvisionnement->removeElement($approvisionnement)) {
            // set the owning side to null (unless already changed)
            if ($approvisionnement->getFournisseur() === $this) {
                $approvisionnement->setFournisseur(null);
            }
        }

        return $this;
    }
}
