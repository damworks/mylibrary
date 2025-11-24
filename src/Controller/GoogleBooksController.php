<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GoogleBooksClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GoogleBooksController extends AbstractController
{
    #[Route('/google-books', name: 'google_books', methods: ['GET'])]
    public function googleBooksAction(Request $request, GoogleBooksClient $googleBooksClient): JsonResponse
    {
        $isbn = trim((string) $request->query->get('isbn', ''));

        if ($isbn === '') {
            return $this->json(['error' => 'Missing "isbn" parameter'], 400);
        }

        $volume = $googleBooksClient->findByIsbn($isbn);

        if ($volume === null) {
            return $this->json(['error' => 'No volume found for ISBN ' . $isbn], 404);
        }

        return $this->json($volume);
    }

}
