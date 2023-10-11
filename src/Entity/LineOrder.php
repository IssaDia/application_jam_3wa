<?php

namespace App\Entity;

use App\Repository\LineOrderRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['read']]
)]

#[ORM\Entity(repositoryClass: LineOrderRepository::class)]
class LineOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read'])]
    private $quantity;

    #[ORM\Column(type: 'float')]
    #[Groups(['read'])]
    private $subtotal;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'lineOrders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private $order_associated;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false,onDelete:"CASCADE")]
    #[Groups(['read'])]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getOrderAssociated(): ?Order
    {
        return $this->order_associated;
    }

    public function setOrderAssociated(?Order $order_associated): self
    {
        $this->order_associated = $order_associated;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
    public function __toString(){
        return $this->quantity." ".$this->product->getName();
    }
}
