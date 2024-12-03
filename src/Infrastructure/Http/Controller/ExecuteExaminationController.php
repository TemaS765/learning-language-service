<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CheckExerciseUseCase;
use App\Application\UseCase\ExecuteExaminationUseCase;
use App\Application\UseCase\Request\CheckExerciseRequest;
use App\Application\UseCase\Request\ExecuteExaminationRequest;
use App\Domain\Enum\ExaminationType;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Form\ExamForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExecuteExaminationController extends AbstractController
{
    #[Route('/exam', name: 'exam', methods: ['GET'])]
    public function exam(ExecuteExaminationUseCase $useCase): Response
    {
        try {
            $response = $useCase(new ExecuteExaminationRequest(ExaminationType::EXAM));
        } catch (NotFoundException $exception) {
            return $this->redirect('/');
        }

        $form = $this->createForm(
            ExamForm::class,
            ['question' => $response->question, 'exercise_id' => $response->exercise_id],
            ['button_label' => 'Проверить']
        );

        return $this->render('exam/exam.html.twig', ['form' => $form, 'page_title' => 'Проверка']);
    }

    #[Route('/exam', name: 'check_exam', methods: ['POST'])]
    public function checkExam(Request $request, CheckExerciseUseCase $useCase): Response
    {
        $form = $this->createForm(ExamForm::class, null, ['button_label' => 'Проверить']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $res = $useCase(new CheckExerciseRequest((int) $data['exercise_id'], (string) $data['answer']));
                $form = $this->createForm(
                    ExamForm::class,
                    $data,
                    [
                        'button_label' => 'Далее',
                        'validation_mode' => $res->isCorrect ? 'valid' : 'invalid',
                        'readonly_form' => true,
                    ]
                );
            } catch (NotFoundException $exception) {
                return $this->redirectToRoute('exam');
            }
        }

        return $this->render('exam/exam.html.twig', ['form' => $form, 'page_title' => 'Проверка']);
    }

    #[Route('/train', name: 'train', methods: ['GET'])]
    public function train(ExecuteExaminationUseCase $useCase): Response
    {
        try {
            $response = $useCase(new ExecuteExaminationRequest(ExaminationType::TRAIN));
        } catch (NotFoundException $exception) {
            return $this->redirect('/');
        }

        $form = $this->createForm(
            ExamForm::class,
            ['question' => $response->question, 'exercise_id' => $response->exercise_id],
            ['button_label' => 'Проверить']
        );

        return $this->render('exam/exam.html.twig', ['form' => $form, 'page_title' => 'Обучение']);
    }

    #[Route('/train', name: 'check_train', methods: ['POST'])]
    public function checkTrain(Request $request, CheckExerciseUseCase $useCase): Response
    {
        $form = $this->createForm(ExamForm::class, null, ['button_label' => 'Проверить']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $res = $useCase(new CheckExerciseRequest((int) $data['exercise_id'], (string) $data['answer']));
                $validationMode = $res->isCorrect ? 'valid' : 'invalid';
                $form = $this->createForm(
                    ExamForm::class,
                    $data,
                    [
                        'button_label' => 'Далее',
                        'validation_mode' => $validationMode,
                        'readonly_form' => true,
                    ]
                );
                $message = $res->isCorrect
                    ? 'Верно!'
                    : "Неверно: <strong>{$res->exercise->getCorrectAnswer()->getValue()}</strong>.";
                $this->addFlash($res->isCorrect ? 'success' : 'danger', $message);
            } catch (NotFoundException $exception) {
                return $this->redirectToRoute('train');
            }
        }

        return $this->render('exam/exam.html.twig', ['form' => $form, 'page_title' => 'Обучение']);
    }
}
