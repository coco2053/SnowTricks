<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickImageRepository")
 */
class TrickImage extends Image
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="trickImages")
     */
    private $trick;

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
