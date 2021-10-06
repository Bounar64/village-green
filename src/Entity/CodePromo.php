<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodePromoRepository::class)
 */
class CodePromo
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
    private $codePromo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actived;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $codeValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(string $codePromo): self
    {
        $this->codePromo = $codePromo;

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

    public function getCodeValue(): ?string
    {
        return $this->codeValue;
    }

    public function setCodeValue(string $codeValue): self
    {
        $this->codeValue = $codeValue;

        return $this;
    }
}
