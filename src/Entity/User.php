<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Entity\Traits\Timestampable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *      fields={"email"}, 
 *      message="Cette e-mail est déjà utilisé !" 
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * // Un texte sans caractère spéciaux sauf "-" "_" "." un '@' obligatoire un "." obligatoire et minimum 2 et max 4 lettres exemple "fr" "com" "gouv"
     * 
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Regex(
     *     pattern="/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,4})$/",
     *     message="Veuillez saisir un e-mail valide."  
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=100)
     * // NotBlank(message="Ce champ est obligatoire.") // DESACTIVER EN ANNOTATION MAIS ACTIVER DANS LE FORMTYPE POUR EVITER PROBLEME EDITION 
     * // \Regex(
     * //    pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*+?&]{8,}$/",
     * //    message="Veuillez saisir au minimun 8 caractères, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial."
     * // )
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe ne correspond pas")
     */
    public $confirm_password; // n'existe pas dans la base de données

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z- áâãäåçèéêëìíîïðòóôõöùúûüýÿ]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z- áâãäåçèéêëìíîïðòóôõöùúûüýÿ]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[[:alnum:] 'áâãäåçèéêëìíîïðòóôõöùúûüýÿ&_-]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $compagny; 

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Regex(
     *     pattern="/^FR[0-9A-Z]{2}\d{9}$/",
     *     message="Saisie invalide."
     * )
     */
    private $vtaNumber;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9A-Z]{14}$/",
     *     message="Saisie invalide."
     * )
     */
    private $rcsNumber;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\Column(type="smallint")
     */
    private $coeff;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Regex(
     *     pattern="/^[[:alnum:] 'áâãäåçèéêëìíîïðòóôõöùúûüýÿ-]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z -]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Regex(
     *     pattern="/^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/",
     *     message="Saisie invalide."
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Regex(
     *     pattern="/^0[6-7]{1}\d{8}$/",
     *     message="Saisie invalide."
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Regex(
     *     pattern="/^0[3-4-2-9]{1}\d{8}$/",
     *     message="Saisie invalide."
     * )
     */
    private $phoneFixe;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9- ]+$/",
     *     message="Saisie invalide."
     * )
     */
    private $additionalAddress;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCompagny(): ?string
    {
        return $this->compagny;
    }

    public function setCompagny(?string $compagny): self
    {
        $this->compagny = $compagny;

        return $this;
    }

    public function getVtaNumber(): ?string
    {
        return $this->vtaNumber;
    }

    public function setVtaNumber(?string $vtaNumber): self
    {
        $this->vtaNumber = $vtaNumber;

        return $this;
    }

    public function getRcsNumber(): ?string
    {
        return $this->rcsNumber;
    }

    public function setRcsNumber(?string $rcsNumber): self
    {
        $this->rcsNumber = $rcsNumber;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCoeff(): ?int
    {
        return $this->coeff;
    }

    public function setCoeff(int $coeff): self
    {
        $this->coeff = $coeff;

        return $this;
    }

    public function getSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(?bool $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhoneFixe(): ?string
    {
        return $this->phoneFixe;
    }

    public function setPhoneFixe(?string $phoneFixe): self
    {
        $this->phoneFixe = $phoneFixe;

        return $this;
    }

    public function getAdditionalAddress(): ?string
    {
        return $this->additionalAddress;
    }

    public function setAdditionalAddress(?string $additionalAddress): self
    {
        $this->additionalAddress = $additionalAddress;

        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirm_password(): string
    {
        return $this->confirm_password;
    }

    public function setConfirm_password(string $confirm_password): self
    {
        $this->password = $confirm_password;

        return $this;
    }

     /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml équivaut -> retun null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Ajout d'un getter pour avoir le nom complet
     */
    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->lastName;
    }
}
