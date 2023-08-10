<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Enum\RolesEnum;
use App\Form\SubjectType;
use App\Repository\StudyClassRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Director)]
#[Route('/subject')]
class SubjectController extends AbstractController
{
	#[Route('/', name: 'app_subject_index', methods: ['GET'])]
	public function index(SubjectRepository $subjectRepository): Response
	{
		return $this->render('subject/index.html.twig', [
			'subjects' => $subjectRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_subject_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager, StudyClassRepository $classRepository): Response
	{
		$subject = new Subject();
		$form = $this->createForm(SubjectType::class, $subject, [
			'study_classes' => $classRepository->findAll()
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($subject);
			$entityManager->flush();

			return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('subject/new.html.twig', [
			'subject' => $subject,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_subject_show', methods: ['GET'])]
	public function show(Subject $subject): Response
	{
		return $this->render('subject/show.html.twig', [
			'subject' => $subject,
		]);
	}

	#[Route('/{id}/edit', name: 'app_subject_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, Subject $subject, EntityManagerInterface $entityManager, StudyClassRepository $classRepository): Response
	{
		$form = $this->createForm(SubjectType::class, $subject, [
			'study_classes' => $classRepository->findAll()
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();

			return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('subject/edit.html.twig', [
			'subject' => $subject,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_subject_delete', methods: ['POST'])]
	public function delete(Request $request, Subject $subject, EntityManagerInterface $entityManager): Response
	{
		if ($this->isCsrfTokenValid('delete' . $subject->getId(), $request->request->get('_token'))) {
			$entityManager->remove($subject);
			$entityManager->flush();
		}

		return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
	}
}
