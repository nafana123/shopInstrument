<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_product = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?string
    {
        return $this->id_product;
    }

    public function setIdProduct(string $id_product): static
    {
        $this->id_product = $id_product;

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
}
