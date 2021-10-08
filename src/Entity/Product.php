<?php

namespace App\Entity;

use App\Entity\Category;
use App\Entity\Supplier;
use App\Entity\SubCategory;
use App\Entity\OrderDetails;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products", indexes={@ORM\Index(columns={"label", "short_label", "brand", "reference"}, flags={"fulltext"})}) // création d'un index fulltext pour la recherche
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    Use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $shortLabel;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $material;

    /**
     * @ORM\Column(type="boolean")
     */
    private $service;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stock;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stockAlert;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actived;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subCategory;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetails::class, mappedBy="product")
     */
    private $orderDetails;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getShortLabel(): ?string
    {
        return $this->shortLabel;
    }

    public function setShortLabel(string $shortLabel): self
    {
        $this->shortLabel = $shortLabel;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getService(): ?bool
    {
        return $this->service;
    }

    public function setService(bool $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStockAlert(): ?int
    {
        return $this->stockAlert;
    }

    public function setStockAlert(int $stockAlert): self
    {
        $this->stockAlert = $stockAlert;

        return $this;
    }

    public function getActived(): ?bool
    {
        return $this->actived;
    }

    public function setActived(bool $actived): self
    {
        $this->actived = $actived;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?Subcategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?Subcategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|OrderDetails[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setProduct($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getProduct() === $this) {
                $orderDetail->setProduct(null);
            }
        }

        return $this;
    }

    public function __toString() // Ajout de cette fonction pour retourner l'objet name sous forme de string
    {  
        return $this->label;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }
}
