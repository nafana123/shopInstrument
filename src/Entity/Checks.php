<?php

namespace App\Entity;

use App\Repository\ChecksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecksRepository::class)]
class Checks

{   public const STATUS_NEW = '1';
    public const STATUS_CONFIRMED = '2';
    public const STATUS_PAID = '3';
    public const STATUS_PROCESSING = '4';
    public const STATUS_SHIPPED = '5';
    public const STATUS_DELIVERED = '6';
    public const STATUS_RETURNED = '7';
    public const STATUS_CANCELLED = '8';
    public const STATUS_PENDING_PAYMENT = '9';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'checks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $count = null;

    #[ORM\Column(length: 255)]
    private ?string $final_price = null;

    #[ORM\Column(length: 255)]
    private ?string $order_number = null;

    #[ORM\Column(length: 255)]
    private ?string $name= null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $itogPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $data = null;

    public function getId(): ?int
    {
        return $this->id;
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


    public function getIdUser(): ?string
    {
        return $this->id_user;
    }

    public function setIdUser(string $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getCount(): ?string
    {
        return $this->count;
    }

    public function setCount(string $count): static
    {
        $this->count = $count;

        return $this;
    }

    public function getFinalPrice(): ?string
    {
        return $this->final_price;
    }

    public function setFinalPrice(string $final_price): static
    {
        $this->final_price = $final_price;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->order_number;
    }

    public function setOrderNumber(string $order_number): static
    {
        $this->order_number = $order_number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getItogPrice(): ?string
    {
        return $this->itogPrice;
    }

    public function setItogPrice(?string $itogPrice): void
    {
        $this->itogPrice = $itogPrice;
    }
    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;
        return $this;
    }
}
