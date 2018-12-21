<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrickGroup", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", cascade={"persist"}))
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrickImage", mappedBy="trick")
     */
    private $trickImages;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->trickImages = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrickImage[]
     */
    public function getTrickImages(): Collection
    {
        return $this->trickImages;
    }

    public function addTrickImage(TrickImage $trickImage): self
    {
        if (!$this->trickImages->contains($trickImage)) {
            $this->trickImages[] = $trickImage;
            $trickImage->setTrick($this);
        }

        return $this;
    }

    public function removeTrickImage(TrickImage $trickImage): self
    {
        if ($this->trickImages->contains($trickImage)) {
            $this->trickImages->removeElement($trickImage);
            // set the owning side to null (unless already changed)
            if ($trickImage->getTrick() === $this) {
                $trickImage->setTrick(null);
            }
        }

        return $this;
    }
}
