<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
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
            ['/inscription'],
            ['/connexion'],
            ['/demande-changement-de-mdp'],
        ];
    }

    public function testRegistration()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'coco2053@hotmail.com',
            'PHP_AUTH_PW'   => 'Code2merde',
        ]);
        $crawler = $client->request('GET', '/inscription');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('register')->form();

        // set some values
        $form['registration[username]'] = 'machin';
        $form['registration[email]'] = 'maxou@gmail.com';
        $form['registration[password]'] = 'motdepasse';
        $form['registration[confirm_password]'] = 'motdepasse';

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
