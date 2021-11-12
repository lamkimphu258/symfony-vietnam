<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/courses/{courseSlug}')]
class LessonController extends AbstractController
{
    #[Route('/lessons/{lessonSlug}', name: 'app_lesson_show')]
    public function show(
        LessonRepository $lessonRepository,
        CourseRepository $courseRepository,
        string $courseSlug,
        string $lessonSlug
    ): Response
    {
        $course = $courseRepository->findOneBySlug($courseSlug);
        $lesson = $lessonRepository->findOneBySlug($course, $lessonSlug);
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
            'course' => $course,
        ]);
    }
}
