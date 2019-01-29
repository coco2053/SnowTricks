<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields= {"email"},
 * message= "L'email que vous avez indiqué est déjà utilisé !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir au moins 8 caracteres !")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe entrés ne sont pas les mêmes !")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="3", minMessage="Votre mot de passe doit contenir au moins 3 caracteres !")
     */
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $confirmationToken = null;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $passwordToken = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AvatarImage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $avatarImage;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * [__construct]
     */
    public function __construct()
    {
        $this->setRegisteredAt(new \DateTime());
    }

    // GETTERS & SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken($token)
    {
        $this->confirmationToken = $token;
    }

    public function getPasswordToken(): ?string
    {
        return $this->passwordToken;
    }

    public function setPasswordToken($token)
    {
        $this->passwordToken = $token;
    }

    public function getAvatarImage(): ?AvatarImage
    {
        return $this->avatarImage;
    }

    public function setAvatarImage(AvatarImage $avatarImage): self
    {
        $this->avatarImage = $avatarImage;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
