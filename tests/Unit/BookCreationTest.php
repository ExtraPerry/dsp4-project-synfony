<?php

namespace App\Tests\Unit;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class BookCreationTest extends TestCase
{
    public function testBookCanBeCreatedWithRequiredFields(): void
    {
        $book = new Book();
        $book->setTitle('Test Book');
        $book->setStockQuantity(5);

        $this->assertSame('Test Book', $book->getTitle());
        $this->assertSame(5, $book->getStockQuantity());
        $this->assertSame('Test Book', (string) $book);
    }

    public function testBookCanSetAllFields(): void
    {
        $book = new Book();
        $book->setTitle('Complete Book');
        $book->setDescription('A complete test book');
        $book->setIsbn('9781234567890');
        $book->setPublicationDate(new \DateTime('2024-01-15'));
        $book->setPageCount(300);
        $book->setCoverImage('https://example.com/cover.jpg');
        $book->setStockQuantity(10);

        $this->assertSame('Complete Book', $book->getTitle());
        $this->assertSame('A complete test book', $book->getDescription());
        $this->assertSame('9781234567890', $book->getIsbn());
        $this->assertSame('2024-01-15', $book->getPublicationDate()->format('Y-m-d'));
        $this->assertSame(300, $book->getPageCount());
        $this->assertSame('https://example.com/cover.jpg', $book->getCoverImage());
        $this->assertSame(10, $book->getStockQuantity());
    }

    public function testBookCanHaveAuthors(): void
    {
        $book = new Book();
        $book->setTitle('Multi-Author Book');

        $author1 = new Author();
        $author1->setFirstName('John');
        $author1->setLastName('Doe');

        $author2 = new Author();
        $author2->setFirstName('Jane');
        $author2->setLastName('Smith');

        $book->addAuthor($author1);
        $book->addAuthor($author2);

        $this->assertCount(2, $book->getAuthors());

        $book->removeAuthor($author1);
        $this->assertCount(1, $book->getAuthors());
    }

    public function testBookCanHaveCategories(): void
    {
        $book = new Book();
        $book->setTitle('Categorized Book');

        $category = new Category();
        $category->setName('Fiction');

        $book->addCategory($category);
        $this->assertCount(1, $book->getCategories());
        $this->assertSame('Fiction', $book->getCategories()->first()->getName());
    }

    public function testBookCanHaveLanguage(): void
    {
        $book = new Book();
        $book->setTitle('English Book');

        $language = new Language();
        $language->setName('English');
        $language->setCode('en');

        $book->setLanguage($language);

        $this->assertSame('English', $book->getLanguage()->getName());
        $this->assertSame('en', $book->getLanguage()->getCode());
    }

    public function testBookAverageRatingReturnsNullWithNoReviews(): void
    {
        $book = new Book();
        $this->assertNull($book->getAverageRating());
    }

    public function testBookDuplicateAuthorNotAdded(): void
    {
        $book = new Book();
        $author = new Author();
        $author->setFirstName('John');
        $author->setLastName('Doe');

        $book->addAuthor($author);
        $book->addAuthor($author);

        $this->assertCount(1, $book->getAuthors());
    }
}
