<?php

namespace App\Entity;

use App\Repository\InstructionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructionRepository::class)]
class Instruction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'instructions', cascade: ['persist', 'remove'])]
    private ?Pattern $pattern = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPattern(): ?Pattern
    {
        return $this->pattern;
    }

    public function setPattern(?Pattern $pattern): static
    {
        // unset the owning side of the relation if necessary
        if ($pattern === null && $this->pattern !== null) {
            $this->pattern->setInstructions(null);
        }

        // set the owning side of the relation if necessary
        if ($pattern !== null && $pattern->getInstructions() !== $this) {
            $pattern->setInstructions($this);
        }

        $this->pattern = $pattern;

        return $this;
    }
}
