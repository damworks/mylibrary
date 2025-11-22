<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Book;
use Pimcore\Model\DataObject\Comic;
use Pimcore\Model\DataObject\Magazine;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends FrontendController
{
    /**
     * Catalog list
     */
    #[Route('/catalog/list', name: 'catalog_list', methods: ['GET'])]
    public function listAction(): JsonResponse
    {
        $products = [];

        // Books (all are leaf nodes)
        foreach (Book::getList()->getObjects() as $book) {
            $products[] = $this->extractProductData($book);
        }

        // Comics: only leaf nodes (no children)
        foreach (Comic::getList()->getObjects() as $comic) {
            if (!$comic->getChildren() || count($comic->getChildren()) === 0) {
                $products[] = $this->extractProductData($comic);
            }
        }

        // Magazines: only leaf nodes (no children)
        foreach (Magazine::getList()->getObjects() as $magazine) {
            if (!$magazine->getChildren() || count($magazine->getChildren()) === 0) {
                $products[] = $this->extractProductData($magazine);
            }
        }

        return new JsonResponse([
            'success' => true,
            'total' => count($products),
            'data' => $products
        ]);
    }

    /**
     * Helper to extract fields cleanly
     */
    protected function extractProductData($object): array
    {
        return [
            'id' => $object->getId(),
            'title' => method_exists($object, 'getTitle') ? $object->getTitle() : '',
            'issue' => method_exists($object, 'getIssue') ? $object->getIssue() : '',
            'price' => method_exists($object, 'getFormattedPrice') ? $object->getFormattedPrice() : '',
            'type'  => method_exists($object, 'getPublicationType') ? $object->getPublicationType() : '',
        ];
    }

    /**
     * Catalog stats: count only child objects for Comic and Magazine
     */
    #[Route('/catalog/stats', name: 'catalog_stats', methods: ['GET'])]
    public function statsAction(): JsonResponse
    {
        $bookCount = Book::getList()->getTotalCount();

        // Comics: count only leaf nodes (no children)
        $comicCount = 0;
        foreach (Comic::getList()->getObjects() as $comic) {
            if (!$comic->getChildren() || count($comic->getChildren()) === 0) {
                $comicCount++;
            }
        }

        // Magazines: count only leaf nodes (no children)
        $magCount = 0;
        foreach (Magazine::getList()->getObjects() as $magazine) {
            if (!$magazine->getChildren() || count($magazine->getChildren()) === 0) {
                $magCount++;
            }
        }

        return new JsonResponse([
            'success' => true,
            'data' => [
                'total_products' => $bookCount + $comicCount + $magCount,
                'books' => $bookCount,
                'comics' => $comicCount,
                'magazines' => $magCount
            ]
        ]);
    }
}
