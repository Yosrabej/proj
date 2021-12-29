<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raison;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandes")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="array")
     */
    private $status = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdAt;
/**
     * @ORM\Column(type="string", length=255)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="demande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

 

  public function __construct(){
     // return $this->createdAt = new \DateTime();
  }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setDateDebut( $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(string $raison): self
    {
        $this->raison = $raison;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
   
    public function getDateFin()
    {
        return $this->dateFin;
    }

    public function setDateFin( $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

  
}