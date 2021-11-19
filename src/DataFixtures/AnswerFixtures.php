<?php

namespace App\DataFixtures;

use App\Factory\AnswerFactory;
use App\Repository\QuestionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private QuestionRepository $questionRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $questions = $this->questionRepository->findAll();

        foreach ($questions as $question) {
            $hasIsCorrectAnswer = false;
            for ($i = 0; $i < 3; $i++) {
                $randCorrectAnswer = rand(0, 1);
                if (!$hasIsCorrectAnswer && $randCorrectAnswer) {
                    AnswerFactory::createOne([
                        'question' => $question,
                        'isCorrect' => $randCorrectAnswer,
                    ]);
                    $hasIsCorrectAnswer = true;
                } else {
                    AnswerFactory::createOne([
                        'question' => $question
                    ]);
                }
            }
        }
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class
        ];
    }
}
