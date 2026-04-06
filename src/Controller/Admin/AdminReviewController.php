<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/reviews')]
#[IsGranted('ROLE_ADMIN')]
class AdminReviewController extends AbstractController
{
    #[Route('', name: 'app_admin_reviews')]
    public function index(ReviewRepository $reviewRepository): Response
    {
        return $this->render('admin/review/index.html.twig', [
            'reviews' => $reviewRepository->findAllWithRelations(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_review_delete', methods: ['POST'])]
    public function delete(Review $review, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
            $this->addFlash('success', 'Review deleted.');
        }
        return $this->redirectToRoute('app_admin_reviews');
    }
}
