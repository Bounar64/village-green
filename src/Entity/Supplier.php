<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $compagny;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $contactFirstName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $contactLastName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $labelProduct;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="supplier")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompagny(): ?string
    {
        return $this->compagny;
    }

    public function setCompagny(string $compagny): self
    {
        $this->compagny = $compagny;

        return $this;
    }

    public function getContactFirstName(): ?string
    {
        return $this->contactFirstName;
    }

    public function setContactFirstName(string $contactFirstName): self
    {
        $this->contactFirstName = $contactFirstName;

        return $this;
    }

    public function getContactLastName(): ?string
    {
        return $this->contactLastName;
    }

    public function setContactLastName(string $contactLastName): self
    {
        $this->contactLastName = $contactLastName;

        return $this;
    }

    public function getLabelProduct(): ?string
    {
        return $this->labelProduct;
    }

    public function setLabelProduct(string $labelProduct): self
    {
        $this->labelProduct = $labelProduct;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }
}
