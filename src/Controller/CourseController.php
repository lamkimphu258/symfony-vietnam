<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\EnrollCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/courses', name: 'app_course_index')]
    public function index(EnrollCourseRepository $enrollCourseRepository): Response
    {
        $enrollCourses = $enrollCourseRepository->findAllByUser($this->getUser());

        return $this->render('course/index.html.twig', [
            'enrollCourses' => $enrollCourses,
        ]);
    }

    #[Route('/courses/{courseSlug}', name: 'app_course_show')]
    public function show(CourseRepository $courseRepository, string $courseSlug): Response
    {
        $courseName = $courseRepository->findOneBySlug($courseSlug)->getName();

        return $this->render('course/show.html.twig', [
            'courseName' => $courseName
        ]);
    }
}