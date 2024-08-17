<?php

namespace App\Entity;

use App\Repository\ProductCharacteristicsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductCharacteristicsRepository::class)]
class ProductCharacteristics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'characteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $characteristic = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getCharacteristic(): ?string{
        return $this->characteristic;
    }
    public function setCharacteristic(string $characteristic): self{
        $this->characteristic = $characteristic;
        return $this;
    }
    public function getValue(): ?string{
        return $this->value;
    }
    public function setValue(string $value): self{
        $this->value = $value;
        return $this;
    }
}
