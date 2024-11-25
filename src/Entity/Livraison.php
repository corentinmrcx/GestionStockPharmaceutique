<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idLiv = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateLiv = null;

    #[ORM\Column]
    private ?int $qte = null;

    #[ORM\Column(length: 255)]
    private ?string $adrLiv = null;

    #[ORM\Column(length: 10)]
    private ?string $cpLiv = null;

    #[ORM\Column(length: 50)]
    private ?string $villeLiv = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->idLiv;
    }

    public function getDateLiv(): ?\DateTimeImmutable
    {
        return $this->dateLiv;
    }

    public function setDateLiv(\DateTimeImmutable $dateLiv): static
    {
        $this->dateLiv = $dateLiv;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getAdrLiv(): ?string
    {
        return $this->adrLiv;
    }

    public function setAdrLiv(string $adrLiv): static
    {
        $this->adrLiv = $adrLiv;

        return $this;
    }

    public function getCpLiv(): ?string
    {
        return $this->cpLiv;
    }

    public function setCpLiv(string $cpLiv): static
    {
        $this->cpLiv = $cpLiv;

        return $this;
    }

    public function getVilleLiv(): ?string
    {
        return $this->villeLiv;
    }

    public function setVilleLiv(string $villeLiv): static
    {
        $this->villeLiv = $villeLiv;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }
}
