<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginsuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login/success/');
    }

    public function testMissingemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login/missing/email');
    }

}
