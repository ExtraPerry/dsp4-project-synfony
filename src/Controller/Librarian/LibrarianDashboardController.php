<?php

namespace App\Controller\Librarian;

use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/librarian')]
#[IsGranted('ROLE_LIBRARIAN')]
class LibrarianDashboardController extends AbstractController
{
    #[Route('', name: 'app_librarian_dashboard')]
    public function index(
        BookRepository $bookRepository,
        ReservationRepository $reservationRepository,
    ): Response {
        $totalBooks = count($bookRepository->findAll());
        $pendingReservations = $reservationRepository->findPending();

        return $this->render('librarian/dashboard.html.twig', [
            'totalBooks' => $totalBooks,
            'pendingReservations' => $pendingReservations,
        ]);
    }
}
