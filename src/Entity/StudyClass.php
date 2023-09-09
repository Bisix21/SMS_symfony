<?php

namespace App\Entity;

use App\Repository\StudyClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyClassRepository::class)]
class StudyClass
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $number = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $description = null;

	#[ORM\OneToMany(mappedBy: 'studyClass', targetEntity: User::class)]
	private Collection $user;

	public function __construct()
	{
		$this->user = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getNumber(): ?string
	{
		return $this->number;
	}

	public function setNumber(string $number): static
	{
		$this->number = $number;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): static
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return Collection<int, User>
	 */
	public function getUser(): Collection
	{
		return $this->user;
	}

	public function addUser(User $user): static
	{
//		dd($this->user);
		if ($this->user->contains($user)) {
			$this->user->add($user);
			$user->setStudyClass($this);
		}

		return $this;
	}

	public function removeUser(User $user): static
	{
		if ($this->user->removeElement($user)) {
			// set the owning side to null (unless already changed)
			if ($user->getStudyClass() === $this) {
				$user->setStudyClass(null);
			}
		}

		return $this;
	}

	public function addClassmate(User $classmate): static
	{
		if (!$this->user->contains($classmate)) {
			$this->user->add($classmate);
			$classmate->setStudyClass($this);
		}

		return $this;
	}


}
