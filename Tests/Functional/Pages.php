<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 19/12/2014
 * Time: 20:04
 */

namespace ConcertoCms\CoreBundle\Tests\Functional;


use ConcertoCms\CoreBundle\Tests\Functional\AbstractWebTestCase;

class Pages extends AbstractWebTestCase {
    public function testGetRequest()
    {
        $client = $this->createClient();
        $crawler = $client->request("GET", "/pages");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $data = json_decode($response->getContent());

        $this->assertTrue(is_array($data));
        $this->assertEquals(6, count($data));

        $crawler = $client->request("GET", "/rest/content/en");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
} 