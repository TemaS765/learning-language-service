<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\DeleteWordUseCase;
use App\Application\UseCase\Request\DeleteWordRequest;
use App\Domain\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteWordController extends AbstractController
{
    #[Route('/word/{id}/delete', name: 'delete_word', methods: ['GET'])]
    public function edit(int $id, DeleteWordUseCase $useCase): Response
    {
        try {
            $useCase(new DeleteWordRequest($id));
        } catch (NotFoundException $exception) {
            $this->addFlash('notice', 'Не найдено слово');

            return $this->redirectToRoute('/');
        }
        $this->addFlash('success', 'Слово удалено');

        return $this->redirectToRoute('get_words');
    }
}
