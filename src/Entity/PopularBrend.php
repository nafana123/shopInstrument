<?php

namespace App\Entity;

use App\Repository\PopularBrendRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopularBrendRepository::class)]
class PopularBrend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?int $deleted = 0;

    public function getId(): ?int
    {
        return $this->id;
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
}
