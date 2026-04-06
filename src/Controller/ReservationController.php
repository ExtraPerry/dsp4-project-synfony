<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Enum\ReservationStatus;
use App\Form\ReservationType;
use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reservation')]
#[IsGranted('ROLE_USER')]
class ReservationController extends AbstractController
{
    #[Route('/new/{bookId}', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(
        int $bookId,
        Request $request,
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $book = $bookRepository->find($bookId);

        if (!$book) {
            throw $this->createNotFoundException('Book not found.');
        }

        if ($book->getStockQuantity() <= 0) {
            $this->addFlash('error', 'This book is currently out of stock.');
            return $this->redirectToRoute('app_book_show', ['id' => $bookId]);
        }

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setBorrower($this->getUser());
            $reservation->setBook($book);
            $reservation->setStatus(ReservationStatus::Pending);

            $book->setStockQuantity($book->getStockQuantity() - 1);

            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Reservation created successfully!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form,
            'book' => $book,
        ]);
    }

    #[Route('/cancel/{id}', name: 'app_reservation_cancel', methods: ['POST'])]
    public function cancel(
        Reservation $reservation,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if ($reservation->getBorrower() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('cancel' . $reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus(ReservationStatus::Cancelled);
            $reservation->getBook()->setStockQuantity(
                $reservation->getBook()->getStockQuantity() + 1
            );
            $entityManager->flush();
            $this->addFlash('success', 'Reservation cancelled.');
        }

        return $this->redirectToRoute('app_profile');
    }
}
