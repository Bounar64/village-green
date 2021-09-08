<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\EmployeeRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\Table(name="employees")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"email"}, message="Cette email et déja utilisé")
 */
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="bigint")
     */
    private $socialSecurityNumber;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sex;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $maritalStatus;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dependentChild;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

     /**
     * @ORM\Column(type="string", length=80)
     */
    private $degree;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $rib;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $firstNameContactPerson;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $lastNameContactPerson;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $addressContactPerson;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $zipCodeContactPerson;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $countryContactPerson;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phoneContactPerson;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialSecurityNumber(): ?int
    {
        return $this->socialSecurityNumber;
    }

    public function setSocialSecurityNumber(int $socialSecurityNumber): self
    {
        $this->socialSecurityNumber = $socialSecurityNumber;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(bool $sex): self
    {
        $this->sex = $sex;

        return $this;
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

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(string $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getDependentChild(): ?int
    {
        return $this->dependentChild;
    }

    public function setDependentChild(int $dependentChild): self
    {
        $this->dependentChild = $dependentChild;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function setDegree(string $degree): self
    {
        $this->degree = $degree;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getFirstNameContactPerson(): ?string
    {
        return $this->firstNameContactPerson;
    }

    public function setFirstNameContactPerson(string $firstNameContactPerson): self
    {
        $this->firstNameContactPerson = $firstNameContactPerson;

        return $this;
    }

    public function getLastNameContactPerson(): ?string
    {
        return $this->lastNameContactPerson;
    }

    public function setLastNameContactPerson(string $lastNameContactPerson): self
    {
        $this->lastNameContactPerson = $lastNameContactPerson;

        return $this;
    }

    public function getAddressContactPerson(): ?string
    {
        return $this->addressContactPerson;
    }

    public function setAddressContactPerson(string $addressContactPerson): self
    {
        $this->addressContactPerson = $addressContactPerson;

        return $this;
    }

    public function getZipCodeContactPerson(): ?string
    {
        return $this->zipCodeContactPerson;
    }

    public function setZipCodeContactPerson(string $zipCodeContactPerson): self
    {
        $this->zipCodeContactPerson = $zipCodeContactPerson;

        return $this;
    }

    public function getCountryContactPerson(): ?string
    {
        return $this->countryContactPerson;
    }

    public function setCountryContactPerson(string $countryContactPerson): self
    {
        $this->countryContactPerson = $countryContactPerson;

        return $this;
    }

    public function getPhoneContactPerson(): ?string
    {
        return $this->phoneContactPerson;
    }

    public function setPhoneContactPerson(string $phoneContactPerson): self
    {
        $this->phoneContactPerson = $phoneContactPerson;

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

}
