<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('Done!!!');
    }
}
