<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $types = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?int $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $noSale = null;

    #[ORM\Column(length: 255)]
    private ?string $discont = null;


    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?int $deleted = 0;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Basket::class)]
    private Collection $basket;

    public function __construct()
    {
        $this->basket = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    public function setTypes(string $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }
    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(?int $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getNoSale(): ?string
    {
        return $this->noSale;
    }

    public function setNoSale(?string $noSale): self
    {
        $this->noSale = $noSale;

        return $this;
    }

    public function getDiscont(): ?string
    {
        return $this->discont;
    }

    public function setDiscont(?string $discont): self
    {
        $this->discont = $discont;
        return $this;
    }
}
