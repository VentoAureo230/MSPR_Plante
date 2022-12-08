<?php

namespace App\Entity;

use App\Repository\PlantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantRepository::class)]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $Level = null;

    #[ORM\Column]
    private ?bool $is_enable_for_user = true;

    #[ORM\Column]
    private ?bool $is_enable = null;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: Hint::class, cascade: ["persist","remove"], orphanRemoval: true)]
    private Collection $hints;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: Answer::class, cascade: ["persist","remove"], orphanRemoval: true)]
    private Collection $answers;

    #[ORM\OneToMany(mappedBy: 'plant', targetEntity: Picture::class, cascade: ["persist","remove"], orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'plant', targetEntity: Achievement::class, cascade: ["persist","remove"])]
    private Collection $get_achievements;

    public function __construct()
    {
        $this->hints = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->get_achievements = new ArrayCollection();
        $this->is_enable = True;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->Level;
    }

    public function setLevel(int $Level): self
    {
        $this->Level = $Level;

        return $this;
    }

    public function isIsEnableForUser(): ?bool
    {
        return $this->is_enable_for_user;
    }

    public function setIsEnableForUser(bool $is_enable_for_user): self
    {
        $this->is_enable_for_user = $is_enable_for_user;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->is_enable;
    }

    public function setIsEnable(bool $is_enable): self
    {
        $this->is_enable = $is_enable;

        return $this;
    }

    /**
     * @return Collection<int, Hint>
     */
    public function getHints(): Collection
    {
        return $this->hints;
    }

    public function addHint(Hint $hint): self
    {
        if (!$this->hints->contains($hint)) {
            $this->hints->add($hint);
            $hint->setPlante($this);
        }

        return $this;
    }

    public function removeHint(Hint $hint): self
    {
        if ($this->hints->removeElement($hint)) {
            // set the owning side to null (unless already changed)
            if ($hint->getPlante() === $this) {
                $hint->setPlante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setPlante($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getPlante() === $this) {
                $answer->setPlante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setPlant($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getPlant() === $this) {
                $picture->setPlant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Achievement>
     */
    public function getGetAchievements(): Collection
    {
        return $this->get_achievements;
    }

    public function addGetAchievement(Achievement $getAchievement): self
    {
        if (!$this->get_achievements->contains($getAchievement)) {
            $this->get_achievements->add($getAchievement);
            $getAchievement->setPlant($this);
        }

        return $this;
    }

    public function removeGetAchievement(Achievement $getAchievement): self
    {
        if ($this->get_achievements->removeElement($getAchievement)) {
            // set the owning side to null (unless already changed)
            if ($getAchievement->getPlant() === $this) {
                $getAchievement->setPlant(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
