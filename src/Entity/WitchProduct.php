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

       /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productImgPath;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $classSelector;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="name")
     */
    private $articles;

    public function __construct()
    {
        $this->witchFormats = new ArrayCollection();
        $this->articles = new ArrayCollection();
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

    public function getProductImgPath(): ?string
    {
        return $this->productImgPath;
    }

    public function setProductImgPath(?string $productImgPath): self
    {
        $this->productImgPath = $productImgPath;

        return $this;
    }

    public function getClassSelector(): ?string
    {
        return $this->classSelector;
    }

    public function setClassSelector(string $classSelector): self
    {
        $this->classSelector = $classSelector;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setName($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getName() === $this) {
                $article->setName(null);
            }
        }

        return $this;
    }
}
