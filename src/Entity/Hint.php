<?php

namespace App\Entity;

use App\Repository\HintRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HintRepository::class)]
class Hint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\ManyToOne(inversedBy: 'hints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plant $plante = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPlante(): ?Plant
    {
        return $this->plante;
    }

    public function setPlante(?Plant $plante): self
    {
        $this->plante = $plante;

        return $this;
    }
}
