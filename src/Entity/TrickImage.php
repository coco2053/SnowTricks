<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TrickImage
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
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private $alt;

    private $path = __DIR__ .'/../../public/uploads/images';

    /**
     * @Assert\Image(
     *     maxSize = "1024k",
     *     mimeTypes={"image/png" ,"images/jpg","image/jpeg"},
     *     mimeTypesMessage = "Svp inserer une image valide (png,jpg,jpeg)")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="trickImages")
     */
    private $trick;

    /**
     * @ORM\PreFlush
     *
     * [Handles image resizing]
     * @return [void]
     */
    public function handle()
    {
        if ($this->file === null) {
            return;
        }

        if ($this->id) {
            if (file_exists($this->path.'/'.$this->url)) {
                unlink($this->path.'/'.$this->url);
            } else {
                return;
            }
        }
        $name = $this->createName();
        $this->setUrl($name);
        $width = 800;
        $height = 450;
        $size = getimagesize($this->file);
        $output = imagecreatetruecolor($width, $height);
        $ratio = min($size[0]/$width, $size[1]/$height);
        $deltax = $size[0]-($ratio * $width);
        $deltay = $size[1]-($ratio * $height);

        if ($this->file-> getClientOriginalExtension() == 'jpeg' or $this->file-> getClientOriginalExtension() == 'jpg') {
            $image = imagecreatefromjpeg($this->file);
            imagecopyresampled($output, $image, 0, 0, $deltax/2, $deltay/2, $width, $height, $size[0]-$deltax, $size[1]-$deltay);
            imagejpeg($output, $this->path.'/'.$this->url, 100);
        }

        if ($this->file-> getClientOriginalExtension() == 'png') {
            $image = imagecreatefrompng($this->file);
            imagecopyresampled($output, $image, 0, 0, $deltax/2, $deltay/2, $width, $height, $size[0]-$deltax, $size[1]-$deltay);
            imagepng($output, $this->path.'/'.$this->url, 3);
        }
    }

    /**
     * @ORM\PreRemove
     *
     * [Handles image file removal]
     * @return [void]
     */
    public function handleRemove()
    {

        if ($this->id) {
            if (file_exists($this->path.'/'.$this->url)) {
                unlink($this->path.'/'.$this->url);
            } else {
                return;
            }
        }
    }

    /**
     * [Generates a unique crypted name]
     * @return [string]
     */
    private function createName(): string
    {
        return md5(uniqid()). $this->file->getClientOriginalName();
    }

    // GETTERS & SETTERS

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
}
