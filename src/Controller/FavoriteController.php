<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/favorite')]
#[IsGranted('ROLE_USER')]
class FavoriteController extends AbstractController
{
    #[Route('/toggle/{bookId}', name: 'app_favorite_toggle', methods: ['POST'])]
    public function toggle(
        int $bookId,
        Request $request,
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $book = $bookRepository->find($bookId);

        if (!$book) {
            throw $this->createNotFoundException('Book not found.');
        }

        if (!$this->isCsrfTokenValid('favorite' . $bookId, $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $user = $this->getUser();

        if ($user->hasFavoriteBook($book)) {
            $user->removeFavoriteBook($book);
            $this->addFlash('success', 'Book removed from favorites.');
        } else {
            $user->addFavoriteBook($book);
            $this->addFlash('success', 'Book added to favorites!');
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_book_show', ['id' => $bookId]);
    }
}
