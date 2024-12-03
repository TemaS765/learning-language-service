<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\AddWordUseCase;
use App\Application\UseCase\Request\AddWordRequest;
use App\Infrastructure\Form\WordForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddWordController extends AbstractController
{
    #[Route('/word/add', name: 'add_word', methods: ['POST', 'GET'])]
    public function add(Request $request, AddWordUseCase $useCase): Response
    {
        $form = $this->createForm(WordForm::class, null, ['button_label' => 'Добавить']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $useCase(new AddWordRequest($data['text'], $data['translate']));

            return $this->redirectToRoute('add_word');
        }

        return $this->render('word/add.html.twig', ['form' => $form]);
    }
}
