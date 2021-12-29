<?php



namespace App\Entity;



use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
* @ORM\Entity(repositoryClass=UserRepository::class)
* @UniqueEntity(
* fields={"email"},
* message= "l'email est déja utilisé" )
*/
class User implements UserInterface
{
/**
* @ORM\Id
* @ORM\GeneratedValue
* @ORM\Column(type="integer")
*/
private $id;



/**
* @ORM\Column(type="string", length=180, unique=true)
*@Assert\Email()
*/
private $email;



/**
* @ORM\Column(type="string")
*/
private $nom;



/**
* @ORM\Column(type="json")
*/
private $roles = [];



/**
* @var string The hashed password
* @ORM\Column(type="string")
*@Assert\Length(min="6", minMessage="Votre mot de passe doit faire minimum 6 caractères")
*/
private $password;



/**
*@Assert\EqualTo(propertyPath="password", message="mot de passe incorrect")
*/
private $cpassword;



/**
* @ORM\Column(type="boolean")
*/
private $typeContrat;



/**
* @ORM\Column(type="string", length=255)
*/
private $prenom;



/**
* @ORM\OneToMany(targetEntity=Projet::class, mappedBy="manager", orphanRemoval=true)
*/
private $projets;





/**
* @ORM\OneToMany(targetEntity=Demande::class, mappedBy="user")
*/
private $demandes;



/**
* @ORM\OneToMany(targetEntity=Projet::class, mappedBy="managerProx")
*/
private $managerProx;

/**
* @ORM\Column(type="string", length=255)
*/
private $supprimer;






public function __construct()
{
$this->projets = new ArrayCollection();
$this->demandes = new ArrayCollection();
$this->managerProx = new ArrayCollection();
}




public function getId(): ?int
{
return $this->id;
}



public function getEmail(): ?string
{
return $this->email;
}



public function getNom(): ?string
{
return $this->nom;
}



public function setEmail(string $email): self
{
$this->email = $email;



return $this;
}



public function setNom(string $nom): self
{
$this->nom = $nom;



return $this;
}



/**
* A visual identifier that represents this user.
*
* @see UserInterface
*/
public function getUsername(): string
{
return (string) $this->email;
}



/**
* @see UserInterface
*/
public function getRoles(): array
{
$roles = $this->roles;
// guarantee every user at least has ROLE_USER
// $roles[] = 'ROLE_USER';



return array_unique($roles);
}



public function setRoles(array $roles): self
{
$this->roles = $roles;



return $this;
}



/**
* @see UserInterface
*/
public function getPassword(): string
{
if ($this->password === null) {
$this->password = '';
}
return $this->password;
}



/**
* @see UserInterface
*/



public function setPassword(string $password): self
{
$this->password = $password;



return $this;
}





/**
* Returning a salt is only needed, if you are not using a modern
* hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
*
* @see UserInterface
*/
public function getSalt(): ?string
{
return null;
}



/**
* @see UserInterface
*/
public function eraseCredentials()
{
// If you store any temporary, sensitive data on the user, clear it here
// $this->plainPassword = null;
}



public function getTypeContrat(): ?bool
{
return $this->typeContrat;
}



public function setTypeContrat(bool $typeContrat): self
{
$this->typeContrat = $typeContrat;



return $this;
}



public function getPrenom(): ?string
{
return $this->prenom;
}



public function setPrenom(string $prenom): self
{
$this->prenom = $prenom;



return $this;
}



/**
* @return Collection|Projet[]
*/
public function getProjets(): Collection
{
return $this->projets;
}



public function addProjet(Projet $projet): self
{
if (!$this->projets->contains($projet)) {
$this->projets[] = $projet;
$projet->setManager($this);
}



return $this;
}



public function removeProjet(Projet $projet): self
{
if ($this->projets->removeElement($projet)) {
// set the owning side to null (unless already changed)
if ($projet->getManager() === $this) {
$projet->setManager(null);
}
}



return $this;
}




/**
* @return Collection|Demande[]
*/
public function getDemandes(): Collection
{
return $this->demandes;
}



public function addDemande(Demande $demande): self
{
if (!$this->demandes->contains($demande)) {
$this->demandes[] = $demande;
$demande->setUser($this);
}



return $this;
}



public function removeDemande(Demande $demande): self
{
if ($this->demandes->removeElement($demande)) {
// set the owning side to null (unless already changed)
if ($demande->getUser() === $this) {
$demande->setUser(null);
}
}



return $this;
}



/**
* @return Collection|Projet[]
*/
public function getManagerProx(): Collection
{
return $this->managerProx;
}



public function addManagerProx(Projet $managerProx): self
{
if (!$this->managerProx->contains($managerProx)) {
$this->managerProx[] = $managerProx;
$managerProx->setManagerProx($this);
}



return $this;
}



public function removeManagerProx(Projet $managerProx): self
{
if ($this->managerProx->removeElement($managerProx)) {
// set the owning side to null (unless already changed)
if ($managerProx->getManagerProx() === $this) {
$managerProx->setManagerProx(null);
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