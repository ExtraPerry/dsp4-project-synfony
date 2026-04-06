<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminUserController extends AbstractController
{
    #[Route('', name: 'app_admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findBy([], ['lastName' => 'ASC']),
        ]);
    }

    #[Route('/{id}/role', name: 'app_admin_user_role', methods: ['POST'])]
    public function changeRole(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!$this->isCsrfTokenValid('role' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $newRole = $request->request->get('role');
        $validRoles = ['ROLE_USER', 'ROLE_LIBRARIAN', 'ROLE_ADMIN'];

        if (!in_array($newRole, $validRoles)) {
            $this->addFlash('error', 'Invalid role.');
            return $this->redirectToRoute('app_admin_users');
        }

        $roles = [];
        if ($newRole !== 'ROLE_USER') {
            $roles[] = $newRole;
        }

        $user->setRoles($roles);
        $entityManager->flush();

        $this->addFlash('success', sprintf('Role updated for %s.', $user->getFullName()));
        return $this->redirectToRoute('app_admin_users');
    }
}
