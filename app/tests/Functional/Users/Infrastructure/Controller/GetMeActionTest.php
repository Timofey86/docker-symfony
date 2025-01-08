<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMeActionTest extends WebTestCase
{

    use FixtureTools;

    public function test_get_me_action()
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $client->request('POST',
            '/api/auth/token/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ])
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data, 'Token is missing in the response.');
        $this->assertNotEmpty($data['token'], 'Token is empty.');
//        $client->loginUser($user);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));



        $client->request('GET', '/api/users/me');
        // Проверка ответа
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Expected status code 200.');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($user->getEmail(), $data['email']);
    }

}