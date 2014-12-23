<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 19/12/2014
 * Time: 20:04
 */

namespace ConcertoCms\CoreBundle\Tests\Functional;

use ConcertoCms\CoreBundle\Tests\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class Pages extends AbstractWebTestCase
{
    public function testListAction()
    {
        $client = $this->createClient();
        $crawler = $client->request("GET", "/pages");
        $data = $this->checkAndReturnJsonResult($client->getResponse());
        $this->assertEquals(6, count($data));
    }

    public function testGetAction()
    {
        $client = $this->createClient();
        $crawler = $client->request("GET", "/pages/en/company");
        $data = $this->checkAndReturnJsonResult($client->getResponse());
        $this->assertObjectHasAttribute("id", $data);
        $this->assertObjectHasAttribute("title", $data);
        $this->assertObjectHasAttribute("routes", $data);
        $this->assertEquals("/cms/pages/en/company", $data->id);
        $this->assertEquals("Meet the company", $data->title);
        $this->assertEquals(1, count($data->routes));
    }

    /**
     * @param Response $response
     */
    private function checkAndReturnJsonResult(Response $response)
    {
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $data = json_decode($response->getContent());

        $this->assertTrue(is_array($data) || is_object($data));
        return $data;
    }
}
