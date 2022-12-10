<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $experience = 0;

    #[ORM\Column]
    private ?bool $is_admin = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Achievement::class)]
    private Collection $get_achievements;

    public function __construct()
    {
        $this->get_achievements = new ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

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
            $getAchievement->setUser($this);
        }

        return $this;
    }

    public function removeGetAchievement(Achievement $getAchievement): self
    {
        if ($this->get_achievements->removeElement($getAchievement)) {
            // set the owning side to null (unless already changed)
            if ($getAchievement->getUser() === $this) {
                $getAchievement->setUser(null);
            }
        }

        return $this;
    }
}
