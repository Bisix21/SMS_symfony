<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\MessagesEnum;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use App\Service\ControllerService;
use App\Service\RolesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends ControllerService
{
    #[Route('/register', name: 'app_register')]
    public function register(
		Request $request,
		UserPasswordHasherInterface $userPasswordHasher,
		UserAuthenticatorInterface $userAuthenticator,
		UserAuthenticator $authenticator,
		EntityManagerInterface $entityManager,
        RolesService $rolesService
    ): Response
    {
	    if ($this->getUser()) {
		    $this->addFlash(MessagesEnum::WARNING_LOGIN_ALREADY->name, MessagesEnum::WARNING_LOGIN_ALREADY->value);
		    return $rolesService->handleRolesRedirect();
	    }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
