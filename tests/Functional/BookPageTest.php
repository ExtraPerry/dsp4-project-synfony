<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookPageTest extends WebTestCase
{
    public function testBookIndexReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book');

        $this->assertResponseIsSuccessful();
    }

    public function testBookIndexContainsSearchForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/book');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Book Catalog');
        $this->assertSelectorExists('.search-form');
        $this->assertSelectorExists('input[name="q"]');
        $this->assertSelectorExists('input[name="author"]');
        $this->assertSelectorExists('select[name="category"]');
    }

    public function testBookSearchWithEmptyQuery(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book?q=&author=&category=');

        $this->assertResponseIsSuccessful();
    }

    public function testBookSearchWithNonExistentTitle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/book?q=nonexistentbooktitle12345');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.no-results', 'No books found');
    }

    public function testBookShowReturns404ForNonExistentBook(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book/99999');

        $this->assertResponseStatusCodeSame(404);
    }
}
