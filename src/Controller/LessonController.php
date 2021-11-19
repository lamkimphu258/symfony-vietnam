<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\CourseRepository;
use App\Repository\EnrollCourseRepository;
use App\Repository\EnrollLessonRepository;
use App\Repository\LessonRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/courses/{courseSlug}')]
class LessonController extends AbstractController
{
    #[Route('/lessons/{lessonSlug}', name: 'app_lesson_show', methods: [Request::METHOD_GET])]
    public function show(
        LessonRepository $lessonRepository,
        CourseRepository $courseRepository,
        QuestionRepository $questionRepository,
        string $courseSlug,
        string $lessonSlug
    ): Response {
        $course = $courseRepository->findOneBySlug($courseSlug);
        $lesson = $lessonRepository->findOneBySlug($course, $lessonSlug);
        $questions = $questionRepository->findBy(['lesson' => $lesson]);

        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
            'course' => $course,
            'questions' => $questions,
        ]);
    }

    #[Route('/lessons/{lessonSlug}', name: 'app_lesson_check_answer', methods: [Request::METHOD_POST])]
    public function checkAnswer(
        Request $request,
        AnswerRepository $answerRepository,
        LessonRepository $lessonRepository,
        CourseRepository $courseRepository,
        EnrollLessonRepository $enrollLessonRepository,
        EnrollCourseRepository $enrollCourseRepository
    ) {
        $lessonSlug = $request->request->get('lessonSlug');
        $courseSlug = $request->request->get('courseSlug');
        $totalCorrectAnswer = 0;
        $totalAnswer = 0;

        $i = 0;
        while (true) {
            $answerId = $request->request->get('answer'.$i);
            if (is_null($answerId)) {
                break;
            }
            $answer = $answerRepository->findOneBy(['id' => $answerId]);
            if ($answer->getIsCorrect()) {
                $totalCorrectAnswer++;
            }
            $i++;
            $totalAnswer++;
        }

        if ($totalAnswer === $totalCorrectAnswer) {
            $lesson = $lessonRepository->findOneBy(['slug' => $lessonSlug]);
            $enrollLesson = $enrollLessonRepository->findOneBy(['lesson' => $lesson]);
            $enrollLesson->finishLesson();
            $enrollLessonRepository->save($enrollLesson);

            $course = $courseRepository->findOneBy(['slug' => $courseSlug]);
            $enrollCourse = $enrollCourseRepository->findOneBy(['course' => $course]);
            $isFinishedCourse = true;
            $enrollLessonOfUsersFinishedAt = $enrollCourseRepository->findFinishedLessonBy($this->getUser(), $course);
            foreach ($enrollLessonOfUsersFinishedAt as $enrollLessonOfUserFinishedAt) {
                if (is_null($enrollLessonOfUserFinishedAt['finished_at'])) {
                    $isFinishedCourse = false;
                }
            }
            if ($isFinishedCourse) {
                $enrollCourse->finishCourse();
                $enrollCourseRepository->save($enrollCourse);
            }
        }

        return $this->render('lesson/result.html.twig', [
            'totalCorrectAnswer' => $totalCorrectAnswer,
            'totalAnswer' => $totalAnswer,
            'lessonSlug' => $lessonSlug,
            'courseSlug' => $courseSlug
        ]);
    }
}
