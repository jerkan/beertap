<?php

declare(strict_types=1);

namespace App\Tests\UI\API;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class GetDispenserMoneySpentControllerTest extends WebTestCase
{
    /** @test */
    public function it_should_return_dispenser_usages_properly()
    {
        $client = static::createClient();

        $dispenserId = $this->createDispenser($client);
        $this->createUsages($dispenserId, $client);

        $uri = sprintf('/api/dispenser/%s/spending', $dispenserId);
        $client->request(Request::METHOD_GET, $uri);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('amount', $responseData);
        $this->assertArrayHasKey('usages', $responseData);
        $this->assertCount(2, $responseData['usages'], 'There should be 2 usages');
    }

    private function createDispenser(KernelBrowser $client): string
    {
        $flowVolume = 0.064;
        $body = json_encode(['flow_volume' => $flowVolume]);
        $client->request(Request::METHOD_POST, '/api/dispenser', [], [], [], $body);

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);

        return $responseData['id'];
    }

    private function createUsages(string $dispenserId, KernelBrowser $client)
    {
        $uri = sprintf('/api/dispenser/%s/status', $dispenserId);
        $updatedAt = (new \DateTime('2020-03-10 13:45:20'))->format('Y-m-d H:i:s');
        $body = json_encode(['status' => 'open', 'updated_at' => $updatedAt]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);
        $this->assertResponseIsSuccessful();

        $uri = sprintf('/api/dispenser/%s/status', $dispenserId);
        $updatedAt = (new \DateTime('2020-03-10 13:45:25'))->format('Y-m-d H:i:s');
        $body = json_encode(['status' => 'close', 'updated_at' => $updatedAt]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);
        $this->assertResponseIsSuccessful();

        $uri = sprintf('/api/dispenser/%s/status', $dispenserId);
        $updatedAt = (new \DateTime('2020-03-10 13:45:35'))->format('Y-m-d H:i:s');
        $body = json_encode(['status' => 'open', 'updated_at' => $updatedAt]);
        $client->request(Request::METHOD_PUT, $uri, [], [], [], $body);
        $this->assertResponseIsSuccessful();

    }
}