<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
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
     * @ORM\Column(type="string", length=20)
     */
    private $cart;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $fake_card_number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed;

    /**
     * @ORM\Column(type="date")
     */
    private $fakeDateExpiration;

    /**
     * @ORM\Column(type="smallint")
     */
    private $fakeSecurityCode;

    /**
     * @ORM\OneToOne(targetEntity=OrderBackup::class, cascade={"persist", "remove"})
     */
    private $orderBackup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }
    
    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getFakeCardNumber(): ?string
    {
        return $this->fake_card_number;
    }

    public function setFakeCardNumber(string $fake_card_number): self
    {
        $this->fake_card_number = $fake_card_number;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function getFakeDateExpiration(): ?\DateTimeInterface
    {
        return $this->fakeDateExpiration;
    }

    public function setFakeDateExpiration(\DateTimeInterface $fakeDateExpiration): self
    {
        $this->fakeDateExpiration = $fakeDateExpiration;

        return $this;
    }

    public function getFakeSecurityCode(): ?int
    {
        return $this->fakeSecurityCode;
    }

    public function setFakeSecurityCode(int $fakeSecurityCode): self
    {
        $this->fakeSecurityCode = $fakeSecurityCode;

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
