<?php

namespace App\Entity;

use App\Repository\WitchFormatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WitchFormatRepository::class)
 */
class WitchFormat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $size;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity=WitchProduct::class, inversedBy="witchFormats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $witchProduct;

    public function __toString()
    {
        return $this->size;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

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

    public function getWitchProduct(): ?WitchProduct
    {
        return $this->witchProduct;
    }

    public function setWitchProduct(?WitchProduct $witchProduct): self
    {
        $this->witchProduct = $witchProduct;

        return $this;
    }
}
