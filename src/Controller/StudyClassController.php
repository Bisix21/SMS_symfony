<?php

namespace App\Controller;

use App\Entity\StudyClass;
use App\Enum\RolesEnum;
use App\Form\StudyClassType;
use App\Repository\StudyClassRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Director)]
#[Route('/class')]
class StudyClassController extends AbstractController
{
	#[Route('/', name: 'app_study_class_index', methods: ['GET'])]
	public function index(StudyClassRepository $studyClassRepository): Response
	{
		return $this->render('study_class/index.html.twig', [
			'study_classes' => $studyClassRepository->findAll(),
		]);
	}

	#[Route('/new', name: 'app_study_class_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $user): Response
	{
		$studyClass = new StudyClass();
		$form = $this->createForm(StudyClassType::class, $studyClass, [
			'students' => $user->selectUsersWithCallbackFilter(
				fn($user) => in_array(RolesEnum::Student, $user->getRoles())
					&& is_null($user->getStudyClass())
			),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			foreach ($form->get('students')->getData() as $student) {
				$studyClass->addStudents($user->find($student));
			}
			$entityManager->persist($studyClass);
			$entityManager->flush();

			return $this->redirectToRoute('app_study_class_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('study_class/new.html.twig', [
			'study_class' => $studyClass,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_study_class_show', methods: ['GET'])]
	public function show(StudyClass $studyClass): Response
	{
		return $this->render('study_class/show.html.twig', [
			'study_class' => $studyClass,
		]);
	}

	#[Route('/{id}/edit', name: 'app_study_class_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, StudyClass $studyClass, EntityManagerInterface $entityManager, UserRepository $user): Response
	{
		$form = $this->createForm(StudyClassType::class, $studyClass, [
			'student' => $user->selectUsersWithCallbackFilter(
				fn($user) => in_array(RolesEnum::Student, $user->getRoles())
					&& is_null($user->getStudyClass())
			),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
			$this->addFlash('notice','Your changes was saved!');
			return $this->redirect($request->headers->get('referer'));
//			return $this->redirectToRoute('app_study_class_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('study_class/edit.html.twig', [
			'study_class' => $studyClass,
			'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_study_class_delete', methods: ['POST'])]
	public function delete(Request $request, StudyClass $studyClass, EntityManagerInterface $entityManager): Response
	{
		if ($this->isCsrfTokenValid('delete' . $studyClass->getId(), $request->request->get('_token'))) {
			$entityManager->remove($studyClass);
			$entityManager->flush();
		}

		return $this->redirectToRoute('app_study_class_index', [], Response::HTTP_SEE_OTHER);
	}
}
