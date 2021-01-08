<?php

namespace App\Entity;

use App\Repository\WitchCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WitchCategoryRepository::class)
 */
class WitchCategory
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=WitchProduct::class, mappedBy="witchCategory")
     */
    private $witchProducts;

    public function __construct()
    {
        $this->witchProducts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $witchProduct->setWitchCategory($this);
        }

        return $this;
    }

    public function removeWitchProduct(WitchProduct $witchProduct): self
    {
        if ($this->witchProducts->removeElement($witchProduct)) {
            // set the owning side to null (unless already changed)
            if ($witchProduct->getWitchCategory() === $this) {
                $witchProduct->setWitchCategory(null);
            }
        }

        return $this;
    }
}
