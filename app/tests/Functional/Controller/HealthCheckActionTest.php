<?php

namespace App\Tests\Functional\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthCheckActionTest extends WebTestCase
{
    public function test_request_responded_successful_result(): void {
        $client = static::createClient();
        $client->request('GET', '/health-check');

        $this->assertResponseIsSuccessful();

        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($jsonResult['status'], 'ok');
    }
}
