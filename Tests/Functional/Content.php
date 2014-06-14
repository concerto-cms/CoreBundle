<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 14/06/14
 * Time: 10:52
 */

namespace ConcertoCms\CoreBundle\Tests\Functional;

class Content extends BaseTestCase
{
    public function testModule()
    {
        $client = $this->createClient();
        $crawler = $client->request("GET", "/content");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    public function testGetRequest()
    {
        $client = $this->createClient();
        $crawler = $client->request("GET", "/rest/content");
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
