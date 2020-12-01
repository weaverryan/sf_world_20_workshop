<?php

namespace App\Tests;

use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ApiTokenFunctionalTest extends WebTestCase
{
    use Factories, ResetDatabase;

    public function testApiToken()
    {
        $client = self::createClient();

        $user = UserFactory::new()->create(['email' => 'foo@example.com']);
        $apiToken = ApiTokenFactory::new()->create([
            'user' => $user,
            'scopes' => ['profile:read', 'profile:write']
        ]);

        // X-TOKEN is the header name
        $client->request('GET', '/secure', [], [], [
            'HTTP_X-TOKEN' => $apiToken->getToken(),
            'HTTP_ACCEPT' => 'application/json'
        ]);

        $this->assertResponseStatusCodeSame(200);

        $content = $client->getResponse()->getContent();
        $this->assertJson($content);
        $data = json_decode($content, true);
        $this->assertEquals([
            'email' => $user->getEmail(),
            'roles' => ['ROLE_USER'],
        ], $data);
    }
}
