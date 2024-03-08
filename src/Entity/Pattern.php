<?php

namespace App\Entity;

use App\Repository\PatternRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: PatternRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pattern implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $yardage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(inversedBy: 'pattern', cascade: ['persist', 'remove'])]
    private ?Instruction $instructions = null;

    #[ORM\ManyToOne(inversedBy: 'patterns')]
    private ?Category $categories = null;

    #[ORM\ManyToMany(targetEntity: Yarn::class, inversedBy: 'patterns')]
    private Collection $yarns;

    #[ORM\Column]
    private ?float $price = null;

    public function __construct()
    {
        $this->yarns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getYardage(): ?int
    {
        return $this->yardage;
    }

    public function setYardage(int $yardage): static
    {
        $this->yardage = $yardage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getInstructions(): ?Instruction
    {
        return $this->instructions;
    }

    public function setInstructions(?Instruction $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, Yarn>
     */
    public function getYarns(): Collection
    {
        return $this->yarns;
    }

    public function addYarn(Yarn $yarn): static
    {
        if (!$this->yarns->contains($yarn)) {
            $this->yarns->add($yarn);
        }

        return $this;
    }

    public function removeYarn(Yarn $yarn): static
    {
        $this->yarns->removeElement($yarn);

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'instructions' => $this->instructions->getDescription(),
            'category' => $this->categories->getName(),
            'yardage' => $this->yardage,
            'image' => $this->image,
            'createdAt' => $this->createdAt,
            'price' => $this->price,
            'yarns' => $this->yarns->getKeys('patterns')
    ];
    }
}
