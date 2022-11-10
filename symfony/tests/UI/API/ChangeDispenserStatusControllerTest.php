<?php

declare(strict_types=1);

namespace App\Tests\UI\API;

use DateTime;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeDispenserStatusControllerTest extends WebTestCase
{
    /** @test */
    public function it_should_open_a_closed_dispenser_ok()
    {
        $client = static::createClient();

        $id = $this->createDispenser($client);

        $uri = sprintf('/api/dispenser/%s/status', $id);
        $body = json_encode(['status' => 'open', 'updated_at' => (new DateTime())->format('Y-m-d H:i:s')]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);
    }

    /** @test */
    public function it_should_not_open_an_already_opened_dispenser_ok()
    {
        $client = static::createClient();

        $id = $this->createDispenser($client);

        $uri = sprintf('/api/dispenser/%s/status', $id);
        $updatedAt = (new DateTime())->format('Y-m-d H:i:s');
        $body = json_encode(['status' => 'open', 'updated_at' => $updatedAt]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);
        $this->assertResponseIsSuccessful();

        $uri = sprintf('/api/dispenser/%s/status', $id);
        $body = json_encode(['status' => 'open', 'updated_at' => $updatedAt]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);
        $this->assertResponseStatusCodeSame(Response::HTTP_CONFLICT);
    }

    protected function createDispenser(KernelBrowser $client): string
    {
        $flowVolume = 1.5;
        $body = json_encode(['flow_volume' => $flowVolume]);
        $client->request(Request::METHOD_POST, '/api/dispenser', [], [], [], $body);

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);

        return $responseData['id'];
    }
}