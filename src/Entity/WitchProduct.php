<?php

namespace App\Entity;

use App\Repository\WitchProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WitchProductRepository::class)
 */
class WitchProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgPath;

    /**
     * @ORM\ManyToOne(targetEntity=WitchCategory::class, inversedBy="witchProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $witchCategory;

    /**
     * @ORM\OneToMany(targetEntity=WitchFormat::class, mappedBy="witchProduct")
     */
    private $witchFormats;

    public function __construct()
    {
        $this->witchFormats = new ArrayCollection();
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

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getImgPath(): ?string
    {
        return $this->imgPath;
    }

    public function setImgPath(string $imgPath): self
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    public function getWitchCategory(): ?WitchCategory
    {
        return $this->witchCategory;
    }

    public function setWitchCategory(?WitchCategory $witchCategory): self
    {
        $this->witchCategory = $witchCategory;

        return $this;
    }

    /**
     * @return Collection|WitchFormat[]
     */
    public function getWitchFormats(): Collection
    {
        return $this->witchFormats;
    }

    public function addWitchFormat(WitchFormat $witchFormat): self
    {
        if (!$this->witchFormats->contains($witchFormat)) {
            $this->witchFormats[] = $witchFormat;
            $witchFormat->setWitchProduct($this);
        }

        return $this;
    }

    public function removeWitchFormat(WitchFormat $witchFormat): self
    {
        if ($this->witchFormats->removeElement($witchFormat)) {
            // set the owning side to null (unless already changed)
            if ($witchFormat->getWitchProduct() === $this) {
                $witchFormat->setWitchProduct(null);
            }
        }

        return $this;
    }
}
