<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Trick;

class WikiControllerTest extends WebTestCase
{

        /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'coco2053@hotmail.com',
            'PHP_AUTH_PW'   => 'Code2merde',
        ]);
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return [
            ['/'],
            ['/figure/1'],
            ['/wiki/ajouter'],
            ['/wiki/1/modifier'],
        ];
    }

    public function testShowTricks()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('a:contains("Ollie")')
            ->eq(0)
            ->link()
        ;
        $crawler = $client->click($link);
        $this->assertContains(
            'planche',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();
        $client->request('GET', '/figure/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/figure/1');
        $link = $crawler
            ->filter('a:contains("Connexion")')
            ->eq(0)
            ->link()
        ;
        $crawler = $client->click($link);
        $this->assertContains(
            'Connexion',
            $client->getResponse()->getContent()
        );
    }

    public function testAdd()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'coco2053@hotmail.com',
            'PHP_AUTH_PW'   => 'Code2merde',
        ]);
        $crawler = $client->request('GET', 'wiki/ajouter');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('add')->form();

        // set some values
        $form['trick[name]'] = 'trick-test';
        $form['trick[content]'] = 'bla bla bla';
        $form['trick[trickGroup]'] = '1';

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testDelete()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'coco2053@hotmail.com',
            'PHP_AUTH_PW'   => 'Code2merde',
        ]);

        $trick = $this->entityManager
            ->getRepository(Trick::class)
            ->findOneBy(['name'=> 'trick-test']);
        $id = $trick->getId();
        $crawler = $client->request('GET', 'wiki/'.$id.'/supprimer');
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
