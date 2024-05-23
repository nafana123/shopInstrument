<?php

namespace App\Entity;

use App\Repository\InfoProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoProductRepository::class)]
class InfoProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_product = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(length: 1255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $volume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $voltage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rown = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $engine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $power = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mixtures = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $drive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $retainer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $connections = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wheels = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motherland = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?string
    {
        return $this->id_product;
    }

    public function setIdProduct(?string $id_product): static
    {
        $this->id_product = $id_product;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getSale(): ?string
    {
        return $this->sale;
    }

    public function setSale(?string $sale): static
    {
        $this->sale = $sale;
        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): static
    {
        $this->weight = $weight;
        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(?string $volume): static
    {
        $this->volume = $volume;
        return $this;
    }

    public function getVoltage(): ?string
    {
        return $this->voltage;
    }

    public function setVoltage(?string $voltage): static
    {
        $this->voltage = $voltage;
        return $this;
    }

    public function getRown(): ?string
    {
        return $this->rown;
    }

    public function setRown(?string $rown): static
    {
        $this->rown = $rown;
        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(?string $engine): static
    {
        $this->engine = $engine;
        return $this;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(?string $power): static
    {
        $this->power = $power;
        return $this;
    }

    public function getMixtures(): ?string
    {
        return $this->mixtures;
    }

    public function setMixtures(?string $mixtures): static
    {
        $this->mixtures = $mixtures;
        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): static
    {
        $this->time = $time;
        return $this;
    }

    public function getDrive(): ?string
    {
        return $this->drive;
    }

    public function setDrive(?string $drive): static
    {
        $this->drive = $drive;
        return $this;
    }

    public function getRetainer(): ?string
    {
        return $this->retainer;
    }

    public function setRetainer(?string $retainer): static
    {
        $this->retainer = $retainer;
        return $this;
    }

    public function getConnections(): ?string
    {
        return $this->connections;
    }

    public function setConnections(?string $connections): static
    {
        $this->connections = $connections;
        return $this;
    }

    public function getWheels(): ?string
    {
        return $this->wheels;
    }

    public function setWheels(?string $wheels): static
    {
        $this->wheels = $wheels;
        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): static
    {
        $this->dimensions = $dimensions;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getMotherland(): ?string
    {
        return $this->motherland;
    }

    public function setMotherland(?string $motherland): static
    {
        $this->motherland = $motherland;
        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;
        return $this;
    }
}
