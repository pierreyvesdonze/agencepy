<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    /**
     * @ORM\Column(type="integer")
     */
    private $witchFormatId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $articleSize;

    /**
     * @ORM\Column(type="integer")
     */
    private $articlePrice;

    public function __construct()
    {
        $this->witchFormat = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getWitchFormatId(): ?int
    {
        return $this->witchFormatId;
    }

    public function setWitchFormatId(int $witchFormatId): self
    {
        $this->witchFormatId = $witchFormatId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArticleSize(): ?string
    {
        return $this->articleSize;
    }

    public function setArticleSize(string $articleSize): self
    {
        $this->articleSize = $articleSize;

        return $this;
    }

    public function getArticlePrice(): ?int
    {
        return $this->articlePrice;
    }

    public function setArticlePrice(int $articlePrice): self
    {
        $this->articlePrice = $articlePrice;

        return $this;
    }
}
