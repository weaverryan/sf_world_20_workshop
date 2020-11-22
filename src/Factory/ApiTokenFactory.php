<?php

namespace App\Factory;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static ApiToken|Proxy findOrCreate(array $attributes)
 * @method static ApiToken|Proxy random()
 * @method static ApiToken[]|Proxy[] randomSet(int $number)
 * @method static ApiToken[]|Proxy[] randomRange(int $min, int $max)
 * @method static ApiTokenRepository|RepositoryProxy repository()
 * @method ApiToken|Proxy create($attributes = [])
 * @method ApiToken[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class ApiTokenFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'user' => UserFactory::new(),
            'scopes' => ['profile:read'],
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(ApiToken $apiToken) {})
        ;
    }

    protected static function getClass(): string
    {
        return ApiToken::class;
    }
}
