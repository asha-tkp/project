<?php

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testAuthoriseFail()
    {
        $client =static::createClient();
        $url = $client->getContainer()->get('router')->generate('product');
        $client->request('GET', $url);
        $this->assertEquals(401,  $client->getResponse()->getStatusCode());
    }
//
    public function testSecureLoad()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'userpass',
        ));

        $url = $client->getContainer()->get('router')->generate('product');
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}