<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="cart", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="cart", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $newArticles;

    public function __construct()
    {
        $this->witchFormats = new ArrayCollection();
        $this->newArticles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

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
     * @return Collection|Article[]
     */
    public function getNewArticles(): Collection
    {
        return $this->newArticles;
    }

    public function addNewArticle(Article $newArticle): self
    {
        if (!$this->newArticles->contains($newArticle)) {
            $this->newArticles[] = $newArticle;
            $newArticle->setCart($this);
        }

        return $this;
    }

    public function removeNewArticle(Article $newArticle): self
    {
        if ($this->newArticles->removeElement($newArticle)) {
            // set the owning side to null (unless already changed)
            if ($newArticle->getCart() === $this) {
                $newArticle->setCart(null);
            }
        }

        return $this;
    }
}
