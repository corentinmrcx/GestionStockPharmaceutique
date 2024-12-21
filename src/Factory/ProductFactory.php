<?php

namespace App\Factory;

use App\Entity\Product;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'expirationDate' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('now', '+2 years')),
            'isRecommended' => self::faker()->boolean(),
            'name' => self::faker()->words(3, true),
            'price' => self::faker()->randomFloat(2, 1, 100),
            'imageName' => self::faker()->randomElement(['doliprane.png', 'citrateBétaine.png', 'gaviscon.png', null]),
            'reference' => self::faker()->bothify('REF-##########'),
            'description' => self::faker()->sentence(10),
            'stock' => StockFactory::createOne(),
            'brand' => BrandFactory::random(),
            'category' => CategoryFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
        ;
    }
}
