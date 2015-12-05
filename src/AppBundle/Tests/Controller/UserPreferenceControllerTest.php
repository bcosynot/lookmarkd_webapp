<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserPreferenceControllerTest extends WebTestCase
{
    public function testDisplayuserpreferences()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/settings');
    }

    public function testSetuserpreference()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/settings/save/{prefKey}/{value}');
    }

}
