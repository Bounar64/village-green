<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`orders`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $datePayment;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $dateSent;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $shipping;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $addressSecond;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typePayment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
        $this->status = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePayment(): ?\DateTimeImmutable
    {
        return $this->datePayment;
    }

    public function setDatePayment(\DateTimeImmutable $datePayment): self
    {
        $this->datePayment = $datePayment;

        return $this;
    }

    public function getDateSent(): ?\DateTimeImmutable
    {
        return $this->dateSent;
    }

    public function setDateSent(\DateTimeImmutable $dateSent): self
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    public function getShipping(): ?bool
    {
        return $this->shipping;
    }

    public function setShipping(?bool $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getAddressSecond(): ?string
    {
        return $this->addressSecond;
    }

    public function setAddressSecond(?string $addressSecond): self
    {
        $this->addressSecond = $addressSecond;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

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
            $orderDetail->setOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrder() === $this) {
                $orderDetail->setOrder(null);
            }
        }

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

    /**
     * @return Collection|Status[]
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of typePayment
     */ 
    public function getTypePayment()
    {
        return $this->typePayment;
    }

    /**
     * Set the value of typePayment
     *
     * @return  self
     */ 
    public function setTypePayment($typePayment)
    {
        $this->typePayment = $typePayment;

        return $this;
    }

    /**
     * Get the value of reference
     */ 
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the value of reference
     *
     * @return  self
     */ 
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
