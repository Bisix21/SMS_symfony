<?php
namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $name = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $description = null;

	#[ORM\ManyToMany(targetEntity: StudyClass::class, inversedBy: 'subjects')]
	private Collection $study_class;

	public function __construct()
	{
		$this->study_class = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
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

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): static
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return Collection<int, StudyClass>
	 */
	public function getStudyClass(): Collection
	{
		return $this->study_class;
	}

	public function addStudyClass(StudyClass $study_class): static
	{
		if (!$this->study_class->contains($study_class)) {
			$this->study_class->add($study_class);
		}

		return $this;
	}

	public function removeStudyClass(StudyClass $study_class): static
	{
		$this->study_class->removeElement($study_class);

		return $this;
	}
}