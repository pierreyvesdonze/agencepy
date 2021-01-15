<?php

namespace App\Entity;

use App\Repository\PostOrderRepository;
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
     * @ORM\ManyToOne(targetEntity=OrderBackup::class, inversedBy="postOrder", cascade={"persist", "remove"})
     */
    private $orderBackup;

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

    public function getOrderBackup(): ?OrderBackup
    {
        return $this->orderBackup;
    }

    public function setOrderBackup(?OrderBackup $orderBackup): self
    {
        $this->orderBackup = $orderBackup;

        return $this;
    }
}
