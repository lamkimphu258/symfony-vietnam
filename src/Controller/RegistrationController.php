<?php

namespace App\Controller;

use App\Entity\EnrollCourse;
use App\Entity\EnrollLesson;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport\Smtp\Auth\AuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        LessonRepository $lessonRepository,
        CourseRepository $courseRepository
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            $courses = $courseRepository->findAll();
            $lessons = $lessonRepository->findAll();
            foreach ($courses as $course) {
                $enrollCourse = new EnrollCourse($user, $course);
                $entityManager->persist($enrollCourse);
            }
            foreach ($lessons as $lesson) {
                $enrollLesson = new EnrollLesson($user, $lesson);
                $entityManager->persist($enrollLesson);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
