<?php

namespace App\Controller\Admin;

use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('', name: 'app_admin_dashboard')]
    public function index(
        BookRepository $bookRepository,
        UserRepository $userRepository,
        ReservationRepository $reservationRepository,
        ReviewRepository $reviewRepository,
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'totalBooks' => count($bookRepository->findAll()),
            'totalUsers' => count($userRepository->findAll()),
            'pendingReservations' => $reservationRepository->findPending(),
            'totalReviews' => count($reviewRepository->findAll()),
        ]);
    }
}
