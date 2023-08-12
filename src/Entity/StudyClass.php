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

	#[ORM\OneToMany(mappedBy: 'study_class', targetEntity: User::class)]
	private Collection $user;

	#[ORM\ManyToMany(targetEntity: Subject::class, mappedBy: 'study_class')]
	#[ORM\JoinTable(name: "subject_study_class",)]
	private Collection $subjects;

	public function __construct()
	{
		$this->user = new ArrayCollection();
		$this->subjects = new ArrayCollection();
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
	public function getStudents(): Collection
	{
		return $this->user;
	}

	public function addStudents(User $userId): static
	{
		if ($userId->getStudyClass() !== $this) {
			$this->user->add($userId);
			$userId->setStudyClass($this);
		}

		return $this;
	}

	public function removeStudents(User $userId): static
	{
		if ($this->user->removeElement($userId)) {
			// set the owning side to null (unless already changed)
			if ($userId->getStudyClass() === $this) {
				$userId->setStudyClass(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, Subject>
	 */
	public function getSubjects(): Collection
	{
		return $this->subjects;
	}

	public function addSubject(Subject $subject): static
	{
		if (!$this->subjects->contains($subject)) {
			$this->subjects->add($subject);
			$subject->addStudyClass($this);
		}

		return $this;
	}

	public function removeSubject(Subject $subject): static
	{
		if ($this->subjects->removeElement($subject)) {
			$subject->removeStudyClass($this);
		}

		return $this;
	}
}
