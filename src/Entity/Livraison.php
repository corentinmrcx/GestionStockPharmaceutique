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

    #[ORM\ManyToOne(targetEntity: 'Client', inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: 'Employe', inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employe $employe = null;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(Employe $employe): static
    {
        $this->employe = $employe;

        return $this;
    }

}
