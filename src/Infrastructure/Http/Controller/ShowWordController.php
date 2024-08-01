<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\ShowWordsUseCase;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Form\WordForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowWordController extends AbstractController
{
    #[Route('/word/{id}', name: 'show_word', methods: ['GET'])]
    public function show(string $id, ShowWordsUseCase $useCase): Response
    {
        try {
            $word = $useCase((int) $id);
        } catch (NotFoundException $exception) {
            return $this->redirect('/');
        }

        $form = $this->createForm(WordForm::class, $word, ['button_label' => 'Изменить']);

        return $this->render('word/edit.html.twig', ['form' => $form]);
    }
}
