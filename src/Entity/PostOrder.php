<?php

namespace App\Entity;

use App\Repository\PostOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostOrderRepository::class)
 */
class PostOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $productName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $productFormat;

    /**
     * @ORM\Column(type="smallint")
     */
    private $productPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=WitchProduct::class, mappedBy="postOrders")
     */
    private $witchProducts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->witchProducts = new ArrayCollection();
        $this->createdAt = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductFormat(): ?string
    {
        return $this->productFormat;
    }

    public function setProductFormat(string $productFormat): self
    {
        $this->productFormat = $productFormat;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|WitchProduct[]
     */
    public function getWitchProducts(): Collection
    {
        return $this->witchProducts;
    }

    public function addWitchProduct(WitchProduct $witchProduct): self
    {
        if (!$this->witchProducts->contains($witchProduct)) {
            $this->witchProducts[] = $witchProduct;
            $witchProduct->addPostOrder($this);
        }

        return $this;
    }

    public function removeWitchProduct(WitchProduct $witchProduct): self
    {
        if ($this->witchProducts->removeElement($witchProduct)) {
            $witchProduct->removePostOrder($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
