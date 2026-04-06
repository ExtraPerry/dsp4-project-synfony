<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    public function testHomePageReturnsSuccessfulResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testHomePageContainsExpectedContent(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to LibraryHub');
        $this->assertSelectorExists('.navbar');
        $this->assertSelectorExists('.hero');
        $this->assertSelectorTextContains('.navbar-brand', 'LibraryHub');
    }

    public function testHomePageHasNavigationLinks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSelectorExists('a[href="/"]');
        $this->assertSelectorExists('a[href="/book"]');
        $this->assertSelectorExists('a[href="/login"]');
        $this->assertSelectorExists('a[href="/register"]');
    }

    public function testHomePageCatalogLinkWorks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a[href="/book"]')->first()->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
    }
}
