<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ryan = UserFactory::new()->create([
            'email' => 'ryan@symfonycasts.com',
            'plainPassword' => User::GLOBAL_DEFAULT_PASSWORD,
            'roles' => ['ROLE_USER', 'ROLE_ADMIN']
        ]);

        ApiTokenFactory::new()->createMany(2, [
            'user' => $ryan,
        ]);

        $fabien = UserFactory::new()->create([
            'email' => 'fabien@symfony.com',
            'plainPassword' => 'foo',
        ]);

        ApiTokenFactory::new()->createMany(2, [
            'user' => $fabien,
        ]);

        $badUser = UserFactory::new()->create([
            'email' => 'bad_user@symfony.com',
            'plainPassword' => 'foo',
        ]);

        ApiTokenFactory::new()->createMany(2, [
            'user' => $badUser,
        ]);
    }
}
