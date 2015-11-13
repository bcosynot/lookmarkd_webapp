<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testViewprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/');
    }

    public function testEditprofile()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profile/edit/$fieldName');
    }

}
