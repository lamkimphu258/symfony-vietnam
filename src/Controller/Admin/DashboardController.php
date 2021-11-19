<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Question;
use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private UserRepository $userRepository,
        private CourseRepository $courseRepository,
        private LessonRepository $lessonRepository,
        private QuestionRepository $questionRepository,
        private AnswerRepository $answerRepository
    ) {
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        $totalUser = count($this->userRepository->findAll());
        $totalCourse = count($this->courseRepository->findAll());
        $totalLesson = count($this->lessonRepository->findAll());
        $totalQuestion = count($this->questionRepository->findAll());
        $totalAnswer = count($this->answerRepository->findAll());

        return $this->render('admin/dashboard/main.html.twig', [
            'totalUser' => $totalUser,
            'totalCourse' => $totalCourse,
            'totalLesson' => $totalLesson,
            'totalQuestion' => $totalQuestion,
            'totalAnswer' => $totalAnswer,
            'userIdentifier' => $this->getUser()->getUserIdentifier(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Vietnam');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Content Management');
        yield MenuItem::linkToCrud('Courses', 'fa fa-book', Course::class);
        yield MenuItem::linkToCrud('Lessons', 'fa fa-book-open', Lesson::class);
        yield MenuItem::linkToCrud('Questions', 'fa fa-question-circle', Question::class);
        yield MenuItem::linkToCrud('Answers', 'fa fa-scroll', Answer::class);

        yield MenuItem::section('User Management');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
    }
}
