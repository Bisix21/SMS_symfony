<?php

namespace App\Entity;

use App\Enum\RolesEnum;
use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
   	#[ORM\GeneratedValue]
   	#[ORM\Column]
   	private ?int $id = null;

	#[ORM\Column(length: 180, unique: true)]
   	private ?string $email = null;

	#[ORM\Column]
   	private array $roles = [];

	/**
	 * @var string The hashed password
	 */
	#[ORM\Column]
   	private ?string $password = null;

	#[ORM\Column(length: 255)]
   	private ?string $firstName = null;

	#[ORM\Column(length: 255)]
   	private ?string $name = null;

	#[ORM\Column(length: 255)]
   	private ?string $surName = null;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
   	private ?DateTimeInterface $birthday = null;

	#[ORM\Column(nullable: true)]
   	private ?bool $verified = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?StudyClass $studyClass = null;

	public function __construct()
   	{
   
   	}

	public function getId(): ?int
   	{
   		return $this->id;
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

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
   	{
   		return (string)$this->email;
   	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
   	{
   		$roles = $this->roles;
   		// guarantee every user at least has ROLE_USER
   		$roles[] = RolesEnum::User;
   
   		return array_unique($roles);
   	}

	public function setRoles(array $roles): static
   	{
   		$this->roles = $roles;
   
   		return $this;
   	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
   	{
   		return $this->password;
   	}

	public function setPassword(string $password = "password"): static
   	{
   		$this->password = $password;
   
   		return $this;
   	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
   	{
   		// If you store any temporary, sensitive data on the user, clear it here
   		// $this->plainPassword = null;
   	}

	public function getBirthday(): ?DateTimeInterface
   	{
   		return $this->birthday;
   	}

	public function setBirthday(?DateTimeInterface $birthday): static
   	{
   		$this->birthday = $birthday;
   
   		return $this;
   	}

	public function isVerified(): ?bool
   	{
   		return $this->verified;
   	}

	public function setVerified(): static
   	{
   		$this->verified = null;
   
   		return $this;
   	}

	public function getFullName(): string
   	{
   		return $this->getFirstName() . ' ' . $this->getName() . ' ' . $this->getSurName();
   	}

	public function getFirstName(): ?string
   	{
   		return $this->firstName;
   	}

	public function setFirstName(string $firstName): static
   	{
   		$this->firstName = $firstName;
   
   		return $this;
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

	public function getSurName(): ?string
   	{
   		return $this->surName;
   	}

	public function setSurName(string $surName): static
   	{
   		$this->surName = $surName;
   
   		return $this;
   	}

	public function getStudyClass(): ?StudyClass
   	{
   		return $this->studyClass;
   	}

	public function setStudyClass(?StudyClass $studyClass): static
   	{
   		$this->studyClass = $studyClass;
   
   		return $this;
   	}
}

