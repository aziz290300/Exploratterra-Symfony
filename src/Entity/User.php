<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "Le champ nom est requis.")]
    private ?string $username = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "Le champ prénom est requis.")]
    private ?string $prenomuser = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "Le champ numéro de téléphone est requis.")]
    private ?string $numtel = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "Le champ email est requis.")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    #[Assert\Regex(pattern: "/@/", message: "L'email doit contenir le caractère '@'.")]
    private ?string $email = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: "Le champ mot de passe est requis.")]
    private ?string $password= null;

    #[ORM\Column(length: 500)]
    private ?array $roles = null;
    

    #[ORM\Column(length: 500)]
    private ?string $reset_token=null;

    /**
 * @ORM\Column(type="boolean")
 */
private $enabled = true;

// ...

public function isEnabled(): bool
{
    return $this->enabled;
}

public function setEnabled(bool $enabled): self
{
    $this->enabled = $enabled;
    return $this;
}
public function isAccountNonLocked(): bool
{
    return $this->enabled;
}

/**
 * @see LockableInterface
 */
public function lock(): void
{
    $this->enabled = false;
}

/**
 * @see LockableInterface
 */
public function unlock(): void
{
    $this->enabled = true;
}


    private ?UserPasswordEncoderInterface $encoder = null;

    // ...

    public function setEncoder(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }
    

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
{
    $this->username = $username;

    return $this;
}

    public function getPrenomuser(): ?string
    {
        return $this->prenomuser;
    }

    public function setPrenomuser(string $prenomuser): static
    {
        $this->prenomuser = $prenomuser;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
{
    $this->password = $password;

    return $this;
}

/**
 * @ORM\PrePersist
 */
public function onPrePersist()
{
    // Encodez le mot de passe avant la persistance
    $encodedPassword = $this->encoder->encodePassword($this, $this->getPassword());
    $this->setPassword($encodedPassword);
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



    public function getSalt(): ?string
    {
        return null;
    }

    

    public function eraseCredentials(): void
    {
        // Supprimer les données sensibles
        // Cette méthode est appelée après que l'authentification a eu lieu et que les informations sensibles doivent être effacées
    }
    
    

 
    public function getResetToken()
    {
        return $this->reset_token;
    }

    /**
     * @param mixed $reset_token
     */
    public function setResetToken($reset_token): void
    {
        $this->reset_token = $reset_token;
    }
}
