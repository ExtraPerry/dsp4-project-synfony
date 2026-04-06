<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/review')]
#[IsGranted('ROLE_USER')]
class ReviewController extends AbstractController
{
    #[Route('/new/{bookId}', name: 'app_review_new', methods: ['GET', 'POST'])]
    public function new(
        int $bookId,
        Request $request,
        BookRepository $bookRepository,
        ReviewRepository $reviewRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $book = $bookRepository->find($bookId);

        if (!$book) {
            throw $this->createNotFoundException('Book not found.');
        }

        $existingReview = $reviewRepository->findByUserAndBook($this->getUser(), $book);
        if ($existingReview) {
            $this->addFlash('error', 'You have already reviewed this book.');
            return $this->redirectToRoute('app_book_show', ['id' => $bookId]);
        }

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setReviewer($this->getUser());
            $review->setBook($book);

            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Review submitted successfully!');
            return $this->redirectToRoute('app_book_show', ['id' => $bookId]);
        }

        return $this->render('review/new.html.twig', [
            'form' => $form,
            'book' => $book,
        ]);
    }
}
