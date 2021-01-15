<?php

namespace App\Entity;

use App\Repository\OrderBackupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderBackupRepository::class)
 */
class OrderBackup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=PostOrder::class, mappedBy="orderBackup")
     */
    private $postOrder;

    public function __construct()
    {
        $this->postOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|PostOrder[]
     */
    public function getPostOrder(): Collection
    {
        return $this->postOrder;
    }

    public function addPostOrder(PostOrder $postOrder): self
    {
        if (!$this->postOrder->contains($postOrder)) {
            $this->postOrder[] = $postOrder;
            $postOrder->setOrderBackup($this);
        }

        return $this;
    }

    public function removePostOrder(PostOrder $postOrder): self
    {
        if ($this->postOrder->removeElement($postOrder)) {
            // set the owning side to null (unless already changed)
            if ($postOrder->getOrderBackup() === $this) {
                $postOrder->setOrderBackup(null);
            }
        }

        return $this;
    }
}
