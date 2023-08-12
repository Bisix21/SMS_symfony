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
	private ?string $first_name = null;

	#[ORM\Column(length: 255)]
	private ?string $name = null;

	#[ORM\Column(length: 255)]
	private ?string $sur_name = null;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
	private ?DateTimeInterface $birthday = null;

	#[ORM\ManyToOne(targetEntity: StudyClass::class, inversedBy: 'study_class')]
	private ?StudyClass $study_class = null;

	#[ORM\Column(nullable: true)]
	private ?bool $verified = null;

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

	public function getStudyClass(): ?StudyClass
	{
		return $this->study_class;
	}

	public function setStudyClass(?StudyClass $study_class): static
	{
		$this->study_class = $study_class;

		return $this;
	}

	public function isVerified(): ?bool
	{
		return $this->verified;
	}

	public function setVerified(bool $verified): static
	{
		$this->verified = $verified;

		return $this;
	}

	public function getFullName(): string
	{
		return $this->getFirstName() . ' ' . $this->getName() . ' ' . $this->getSurName();
	}

	public function getFirstName(): ?string
	{
		return $this->first_name;
	}

	public function setFirstName(string $first_name): static
	{
		$this->first_name = $first_name;

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
		return $this->sur_name;
	}

	public function setSurName(string $sur_name): static
	{
		$this->sur_name = $sur_name;

		return $this;
	}
}

