<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Language;
use App\Enum\ReservationStatus;
use App\Entity\Reservation;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Form\CategoryType;
use App\Form\LanguageType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\LanguageRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminBookController extends AbstractController
{
    // --- BOOKS ---

    #[Route('/books', name: 'app_admin_books')]
    public function bookList(BookRepository $bookRepository): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'books' => $bookRepository->findBy([], ['title' => 'ASC']),
        ]);
    }

    #[Route('/books/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    public function bookNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Book created successfully.');
            return $this->redirectToRoute('app_admin_books');
        }

        return $this->render('admin/book/new.html.twig', ['form' => $form]);
    }

    #[Route('/books/{id}/edit', name: 'app_admin_book_edit', methods: ['GET', 'POST'])]
    public function bookEdit(Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Book updated successfully.');
            return $this->redirectToRoute('app_admin_books');
        }

        return $this->render('admin/book/edit.html.twig', ['form' => $form, 'book' => $book]);
    }

    #[Route('/books/{id}/delete', name: 'app_admin_book_delete', methods: ['POST'])]
    public function bookDelete(Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('success', 'Book deleted.');
        }
        return $this->redirectToRoute('app_admin_books');
    }

    // --- AUTHORS ---

    #[Route('/authors', name: 'app_admin_authors')]
    public function authorList(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/author/index.html.twig', [
            'authors' => $authorRepository->findBy([], ['lastName' => 'ASC']),
        ]);
    }

    #[Route('/authors/new', name: 'app_admin_author_new', methods: ['GET', 'POST'])]
    public function authorNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success', 'Author created.');
            return $this->redirectToRoute('app_admin_authors');
        }

        return $this->render('admin/author/new.html.twig', ['form' => $form]);
    }

    #[Route('/authors/{id}/edit', name: 'app_admin_author_edit', methods: ['GET', 'POST'])]
    public function authorEdit(Author $author, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Author updated.');
            return $this->redirectToRoute('app_admin_authors');
        }

        return $this->render('admin/author/edit.html.twig', ['form' => $form, 'author' => $author]);
    }

    #[Route('/authors/{id}/delete', name: 'app_admin_author_delete', methods: ['POST'])]
    public function authorDelete(Author $author, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $author->getId(), $request->request->get('_token'))) {
            $entityManager->remove($author);
            $entityManager->flush();
            $this->addFlash('success', 'Author deleted.');
        }
        return $this->redirectToRoute('app_admin_authors');
    }

    // --- CATEGORIES ---

    #[Route('/categories', name: 'app_admin_categories')]
    public function categoryList(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/categories/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function categoryNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Category created.');
            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/category/new.html.twig', ['form' => $form]);
    }

    #[Route('/categories/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function categoryEdit(Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Category updated.');
            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/category/edit.html.twig', ['form' => $form, 'category' => $category]);
    }

    #[Route('/categories/{id}/delete', name: 'app_admin_category_delete', methods: ['POST'])]
    public function categoryDelete(Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
            $this->addFlash('success', 'Category deleted.');
        }
        return $this->redirectToRoute('app_admin_categories');
    }

    // --- LANGUAGES ---

    #[Route('/languages', name: 'app_admin_languages')]
    public function languageList(LanguageRepository $languageRepository): Response
    {
        return $this->render('admin/language/index.html.twig', [
            'languages' => $languageRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/languages/new', name: 'app_admin_language_new', methods: ['GET', 'POST'])]
    public function languageNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($language);
            $entityManager->flush();
            $this->addFlash('success', 'Language created.');
            return $this->redirectToRoute('app_admin_languages');
        }

        return $this->render('admin/language/new.html.twig', ['form' => $form]);
    }

    #[Route('/languages/{id}/edit', name: 'app_admin_language_edit', methods: ['GET', 'POST'])]
    public function languageEdit(Language $language, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Language updated.');
            return $this->redirectToRoute('app_admin_languages');
        }

        return $this->render('admin/language/edit.html.twig', ['form' => $form, 'language' => $language]);
    }

    #[Route('/languages/{id}/delete', name: 'app_admin_language_delete', methods: ['POST'])]
    public function languageDelete(Language $language, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $language->getId(), $request->request->get('_token'))) {
            $entityManager->remove($language);
            $entityManager->flush();
            $this->addFlash('success', 'Language deleted.');
        }
        return $this->redirectToRoute('app_admin_languages');
    }

    // --- RESERVATIONS ---

    #[Route('/reservations', name: 'app_admin_reservations')]
    public function reservationList(ReservationRepository $reservationRepository): Response
    {
        return $this->render('admin/reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAllWithRelations(),
        ]);
    }

    #[Route('/reservations/{id}/confirm', name: 'app_admin_reservation_confirm', methods: ['POST'])]
    public function reservationConfirm(Reservation $reservation, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('confirm' . $reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus(ReservationStatus::Confirmed);
            $entityManager->flush();
            $this->addFlash('success', 'Reservation confirmed.');
        }
        return $this->redirectToRoute('app_admin_reservations');
    }

    #[Route('/reservations/{id}/return', name: 'app_admin_reservation_return', methods: ['POST'])]
    public function reservationReturn(Reservation $reservation, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('return' . $reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus(ReservationStatus::Returned);
            $reservation->getBook()->setStockQuantity(
                $reservation->getBook()->getStockQuantity() + 1
            );
            $entityManager->flush();
            $this->addFlash('success', 'Book returned and stock updated.');
        }
        return $this->redirectToRoute('app_admin_reservations');
    }

    #[Route('/reservations/{id}/cancel', name: 'app_admin_reservation_cancel', methods: ['POST'])]
    public function reservationCancel(Reservation $reservation, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('cancel' . $reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus(ReservationStatus::Cancelled);
            $reservation->getBook()->setStockQuantity(
                $reservation->getBook()->getStockQuantity() + 1
            );
            $entityManager->flush();
            $this->addFlash('success', 'Reservation cancelled.');
        }
        return $this->redirectToRoute('app_admin_reservations');
    }
}
