<?php

namespace App\Controller;

use App\Entity\StudyClass;
use App\Entity\User;
use App\Enum\RolesEnum;
use App\Form\StudyClassType;
use App\Repository\StudyClassRepository;
use App\Repository\UserRepository;
use App\Service\StudyClassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Teacher)]
#[Route('/class')]
class StudyClassController extends AbstractController
{
	public function __construct(
		protected UserRepository       $userRepository,
		protected StudyClassRepository $studyClass,
		protected StudyClassService    $studyClassService,
	)
	{
	}

	#[Route('/', name: 'app_study_class_index', methods: ['GET'])]
	public function index(StudyClassRepository $studyClassRepository): Response
	{
		return $this->render('study_class/index.html.twig', [
			'study_classes' => $studyClassRepository->findAll(),
		]);
	}
	#[IsGranted(RolesEnum::Director)]
	#[Route('/new', name: 'app_study_class_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
	{
		$studyClass = new StudyClass();
		$form = $this->createForm(StudyClassType::class, $studyClass, [
			'student' => $this->studyClassService->getStudents(),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->studyClass->addStudents($form->get('students')->getData(), $studyClass, $this->userRepository);
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
	#[IsGranted(RolesEnum::Director)]
	#[Route('/{id}/edit', name: 'app_study_class_edit', methods: ['GET', 'POST'])]
	public function edit(int $id, Request $request, StudyClass $studyClass, EntityManagerInterface $entityManager): Response
	{
		$form = $this->createForm(StudyClassType::class, $studyClass, [
			'student' => $this->studyClassService->getStudents(),
		]);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->studyClass->addStudents($form->get('students')->getData(), $studyClass, $this->userRepository);
			$entityManager->flush();
			$this->addFlash('notice', 'Your changes was saved!');
			return $this->redirect($request->headers->get('referer'));
		}

		return $this->render('study_class/edit.html.twig', [
			'study_class' => $studyClass,
			'form' => $form,
			'usersList' => $this->userRepository->getClassUsers($id)
		]);
	}
	#[IsGranted(RolesEnum::Director)]
	#[Route('/{id}', name: 'app_study_class_delete', methods: ['POST'])]
	public function delete(Request $request, StudyClass $studyClass, EntityManagerInterface $entityManager): Response
	{
		if ($this->isCsrfTokenValid('delete' . $studyClass->getId(), $request->request->get('_token'))) {
			try {
				$entityManager->remove($studyClass);
				$entityManager->flush();
			} catch (\Exception $exception) {
				$this->addFlash('error', $exception->getMessage());
			}
		}

		return $this->redirectToRoute('app_study_class_index', [], Response::HTTP_SEE_OTHER);
	}
	#[IsGranted(RolesEnum::Director)]
	#[Route('/remove-user/{id}', name: 'app_study_class_remove', methods: ['POST'])]
	public function removeUserFromClass(int $id, Request $request, User $user, EntityManagerInterface $entityManager): RedirectResponse
	{
		if ($this->isCsrfTokenValid('remove' . $id, $request->request->get('_token'))) {
			$user->setStudyClass(null);
			$entityManager->flush();
			$this->addFlash('notice', 'User was deleted form class.');
		};
		return $this->redirect($request->headers->get('referer'));
	}
}
