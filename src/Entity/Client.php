<?php

namespace App\Entity;

use App\enum\ClientType;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCli = null;

    #[ORM\Column(length: 50)]
    private ?string $nomCli = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenomCli = null;

    #[ORM\Column(length: 255)]
    private ?string $mailCli = null;

    #[ORM\Column(length: 25)]
    private ?string $telCli = null;

    #[ORM\Column(length: 50)]
    private ?string $loginCli = null;

    #[ORM\Column(length: 255)]
    private ?string $mdpCli = null;

    #[ORM\Column(length: 255)]
    private ?string $adrCli = null;

    #[ORM\Column(length: 50)]
    private ?string $villeCli = null;

    #[ORM\Column(length: 10)]
    private ?string $cpCli = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateNais = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $numRPPS = null;

    #[ORM\Column(length: 255)]
    private ?ClientType $typeCli = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $commande;

    /**
     * @var Collection<int, Livraison>
     */
    #[ORM\OneToMany(targetEntity: Livraison::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $livraisons;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->livraisons = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->idCli;
    }

    public function getIdCli(): ?int
    {
        return $this->idCli;
    }

    public function setIdCli(int $idCli): static
    {
        $this->idCli = $idCli;

        return $this;
    }

    public function getNomCli(): ?string
    {
        return $this->nomCli;
    }

    public function setNomCli(string $nomCli): static
    {
        $this->nomCli = $nomCli;

        return $this;
    }

    public function getPrenomCli(): ?string
    {
        return $this->prenomCli;
    }

    public function setPrenomCli(?string $prenomCli): static
    {
        $this->prenomCli = $prenomCli;

        return $this;
    }

    public function getMailCli(): ?string
    {
        return $this->mailCli;
    }

    public function setMailCli(string $mailCli): static
    {
        $this->mailCli = $mailCli;

        return $this;
    }

    public function getTelCli(): ?string
    {
        return $this->telCli;
    }

    public function setTelCli(string $telCli): static
    {
        $this->telCli = $telCli;

        return $this;
    }

    public function getLoginCli(): ?string
    {
        return $this->loginCli;
    }

    public function setLoginCli(string $loginCli): static
    {
        $this->loginCli = $loginCli;

        return $this;
    }

    public function getMdpCli(): ?string
    {
        return $this->mdpCli;
    }

    public function setMdpCli(string $mdpCli): static
    {
        $this->mdpCli = $mdpCli;

        return $this;
    }

    public function getAdrCli(): ?string
    {
        return $this->adrCli;
    }

    public function setAdrCli(string $adrCli): static
    {
        $this->adrCli = $adrCli;

        return $this;
    }

    public function getVilleCli(): ?string
    {
        return $this->villeCli;
    }

    public function setVilleCli(string $villeCli): static
    {
        $this->villeCli = $villeCli;

        return $this;
    }

    public function getCpCli(): ?string
    {
        return $this->cpCli;
    }

    public function setCpCli(string $cpCli): static
    {
        $this->cpCli = $cpCli;

        return $this;
    }

    public function getDateNais(): ?\DateTimeImmutable
    {
        return $this->dateNais;
    }

    public function setDateNais(?\DateTimeImmutable $dateNais): static
    {
        $this->dateNais = $dateNais;

        return $this;
    }

    public function getNumRPPS(): ?string
    {
        return $this->numRPPS;
    }

    public function setNumRPPS(?string $numRPPS): static
    {
        $this->numRPPS = $numRPPS;

        return $this;
    }

    public function getTypeCli(): ?ClientType
    {
        return $this->typeCli;
    }

    public function setTypeCli(ClientType $typeCli): static
    {
        $this->typeCli = $typeCli;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): static
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setClient($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): static
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getClient() === $this) {
                $livraison->setClient(null);
            }
        }

        return $this;
    }
}
