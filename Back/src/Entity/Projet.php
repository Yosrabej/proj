<?php



namespace App\Entity;



use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
* @ORM\Entity(repositoryClass=ProjetRepository::class)
*/
class Projet
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
private $nom;



/**
* @ORM\ManyToOne(targetEntity=User::class, inversedBy="projets")
* @ORM\JoinColumn(nullable=false)
*/
private $manager;



/**
* @ORM\ManyToMany(targetEntity=User::class, inversedBy="projets")
*/
private $collaborateur;




/**
* @ORM\Column(type="string", length=255)
*/
private $surSite;



/**
* @ORM\ManyToOne(targetEntity=User::class, inversedBy="managerProx")
*@ORM\JoinColumn(nullable=true)
*/
private $managerProx;





/**
 * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="projet", orphanRemoval=true)
 */
private $demande;

/**
* @ORM\Column(type="string", length=255)
*/
private $supprimer;



public function __construct()
{
$this->collaborateur = new ArrayCollection();
$this->demande = new ArrayCollection();



}



public function getId(): ?int
{
return $this->id;
}



public function getNom(): ?string
{
return $this->nom;
}



public function setNom(string $nom): self
{
$this->nom = $nom;



return $this;
}



public function getManager(): ?User
{
return $this->manager;
}



public function setManager(?User $manager): self
{
$this->manager = $manager;



return $this;
}



/**
* @return Collection|User[]
*/
public function getCollaborateur(): Collection
{
return $this->collaborateur;
}



public function addCollaborateur(User $collaborateur): self
{
if (!$this->collaborateur->contains($collaborateur)) {
$this->collaborateur[] = $collaborateur;
}



return $this;
}



public function removeCollaborateur(User $collaborateur): self
{
$this->collaborateur->removeElement($collaborateur);



return $this;
}




public function getSurSite(): ?string
{
return $this->surSite;
}



public function setSurSite(string $surSite): self
{
$this->surSite = $surSite;



return $this;
}



public function getManagerProx(): ?User
{
return $this->managerProx;
}



public function setManagerProx(?User $managerProx): self
{
$this->managerProx = $managerProx;



return $this;
}









/**
 * @return Collection|Demande[]
 */
public function getDemande(): Collection
{
    return $this->demande;
}

public function addDemande(Demande $demande): self
{
    if (!$this->demande->contains($demande)) {
        $this->demande[] = $demande;
        $demande->setProjet($this);
    }

    return $this;
}

public function removeDemande(Demande $demande): self
{
    if ($this->demande->removeElement($demande)) {
        // set the owning side to null (unless already changed)
        if ($demande->getProjet() === $this) {
            $demande->setProjet(null);
        }
    }

    return $this;
}

public function getSupprimer(): ?string
{
return $this->supprimer;
}



public function setSupprimer(string $supprimer): self
{
$this->supprimer = $supprimer;



return $this;
}
}