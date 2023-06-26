<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilder;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilder;

class ConditionalAvailabilityCartConnectorServiceFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceFactory
     */
    protected ConditionalAvailabilityCartConnectorServiceFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factory = new ConditionalAvailabilityCartConnectorServiceFactory();
    }

    /**
     * @return void
     */
    public function testCreateItemGroupKeyBuilder(): void
    {
        static::assertInstanceOf(
            ItemGroupKeyBuilder::class,
            $this->factory->createItemGroupKeyBuilder(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestCartItemGroupKeyBuilder(): void
    {
        static::assertInstanceOf(
            RestCartItemGroupKeyBuilder::class,
            $this->factory->createRestCartItemGroupKeyBuilder(),
        );
    }
}
