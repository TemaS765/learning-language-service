<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetWordsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetWordsController extends AbstractController
{
    #[Route('/word', name: 'get_words', methods: ['GET'])]
    public function add(GetWordsUseCase $useCase): Response
    {
        return $this->render('word/get_words.html.twig', ['words' => $useCase()]);
    }
}
