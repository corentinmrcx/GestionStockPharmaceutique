<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idEmp = null;

    #[ORM\Column(length: 50)]
    private ?string $nomEmp = null;

    #[ORM\Column(length: 50)]
    private ?string $prenomEmp = null;

    #[ORM\Column(length: 25)]
    private ?string $telEmp = null;

    #[ORM\Column(length: 255)]
    private ?string $mailEmp = null;

    #[ORM\Column(length: 50)]
    private ?string $loginEmp = null;

    #[ORM\Column(length: 255)]
    private ?string $mdpEmp = null;

    #[ORM\Column(length: 255)]
    private ?string $typeEmp = null;

    /**
     * @var Collection<int, Inventaire>
     */
    #[ORM\ManyToMany(targetEntity: Inventaire::class, mappedBy: 'employe')]
    private Collection $inventaires;

    public function __construct()
    {
        $this->inventaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->idEmp;
    }

    public function getNomEmp(): ?string
    {
        return $this->nomEmp;
    }

    public function setNomEmp(string $nomEmp): static
    {
        $this->nomEmp = $nomEmp;

        return $this;
    }

    public function getPrenomEmp(): ?string
    {
        return $this->prenomEmp;
    }

    public function setPrenomEmp(string $prenomEmp): static
    {
        $this->prenomEmp = $prenomEmp;

        return $this;
    }

    public function getTelEmp(): ?string
    {
        return $this->telEmp;
    }

    public function setTelEmp(string $telEmp): static
    {
        $this->telEmp = $telEmp;

        return $this;
    }

    public function getMailEmp(): ?string
    {
        return $this->mailEmp;
    }

    public function setMailEmp(string $mailEmp): static
    {
        $this->mailEmp = $mailEmp;

        return $this;
    }

    public function getLoginEmp(): ?string
    {
        return $this->loginEmp;
    }

    public function setLoginEmp(string $loginEmp): static
    {
        $this->loginEmp = $loginEmp;

        return $this;
    }

    public function getMdpEmp(): ?string
    {
        return $this->mdpEmp;
    }

    public function setMdpEmp(string $mdpEmp): static
    {
        $this->mdpEmp = $mdpEmp;

        return $this;
    }

    public function getTypeEmp(): ?string
    {
        return $this->typeEmp;
    }

    public function setTypeEmp(string $typeEmp): static
    {
        $this->typeEmp = $typeEmp;

        return $this;
    }

    /**
     * @return Collection<int, Inventaire>
     */
    public function getInventaires(): Collection
    {
        return $this->inventaires;
    }

    public function addInventaire(Inventaire $inventaire): static
    {
        if (!$this->inventaires->contains($inventaire)) {
            $this->inventaires->add($inventaire);
            $inventaire->addEmploye($this);
        }

        return $this;
    }

    public function removeInventaire(Inventaire $inventaire): static
    {
        if ($this->inventaires->removeElement($inventaire)) {
            $inventaire->removeEmploye($this);
        }

        return $this;
    }
}
