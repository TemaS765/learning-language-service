<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\EditWordsUseCase;
use App\Application\UseCase\Request\EditWordRequest;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Form\WordForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditWordController extends AbstractController
{
    #[Route('/word/{id}', name: 'edit_word', methods: ['POST'])]
    public function edit(int $id, Request $request, EditWordsUseCase $useCase): Response
    {
        $form = $this->createForm(WordForm::class, null, ['button_label' => 'Изменить']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $useCase(new EditWordRequest($id, $data['text'], $data['translate']));
            } catch (NotFoundException $exception) {
                $this->addFlash('notice', 'Не найдено слово');
                return $this->redirectToRoute('/');
            }
            $this->addFlash('success', 'Информация обновлена');
            return $this->redirectToRoute('show_word', ['id' => $id]);
        }

        return $this->render('word/edit.html.twig', ['form' => $form]);
    }
}
