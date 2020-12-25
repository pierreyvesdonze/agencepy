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
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="newArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    /**
     * @ORM\Column(type="integer")
     */
    private $witchFormatId;

    public function __construct()
    {
        $this->witchFormat = new ArrayCollection();
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
}
