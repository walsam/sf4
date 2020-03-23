<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="product_order")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetail", mappedBy="order")
     */
    private $orderdetail;

    public function __construct()
    {
        $this->orderdetail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|OrderDetail[]
     */
    public function getOrderdetail(): Collection
    {
        return $this->orderdetail;
    }

    public function addOrderdetail(OrderDetail $orderdetail): self
    {
        if (!$this->orderdetail->contains($orderdetail)) {
            $this->orderdetail[] = $orderdetail;
            $orderdetail->setOrder($this);
        }

        return $this;
    }

    public function removeOrderdetail(OrderDetail $orderdetail): self
    {
        if ($this->orderdetail->contains($orderdetail)) {
            $this->orderdetail->removeElement($orderdetail);
            // set the owning side to null (unless already changed)
            if ($orderdetail->getOrder() === $this) {
                $orderdetail->setOrder(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->createAt;
    }
}
