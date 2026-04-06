<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(
        Request $request,
        BookRepository $bookRepository,
        CategoryRepository $categoryRepository,
    ): Response {
        $query = $request->query->get('q');
        $authorName = $request->query->get('author');
        $categoryRaw = $request->query->get('category', '');
        $categoryId = $categoryRaw !== '' ? (int) $categoryRaw : 0;

        $books = $bookRepository->findBySearchCriteria(
            $query,
            $authorName,
            $categoryId ?: null,
        );

        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'categories' => $categories,
            'currentQuery' => $query,
            'currentAuthor' => $authorName,
            'currentCategory' => $categoryId,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found.');
        }

        $userReview = null;
        if ($this->getUser()) {
            foreach ($book->getReviews() as $review) {
                if ($review->getReviewer() === $this->getUser()) {
                    $userReview = $review;
                    break;
                }
            }
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'userReview' => $userReview,
        ]);
    }
}
