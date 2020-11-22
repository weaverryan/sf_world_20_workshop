<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = UserFactory::new()->create([
            'email' => 'ryan@symfonycasts.com',
            'plainPassword' => 'foo',
        ]);

        ApiTokenFactory::new()->createMany(5, [
            'user' => $user,
        ]);
    }
}
