<?php

declare(strict_types=1);

namespace App\Tests\UI\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateDispenserControllerTest extends WebTestCase
{
    /** @test */
    public function it_should_create_dispenser_ok()
    {
        $client = static::createClient();

        $flowVolume = 1.5;
        $body = json_encode(['flow_volume' => $flowVolume]);
        $client->request('POST', '/api/dispenser', [], [], [], $body);

        $this->assertResponseIsSuccessful();

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertSame($flowVolume, $responseData['flow_volume']);
    }

}