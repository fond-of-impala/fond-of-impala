<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService;

class ConditionalAvailabilityCartConnectorFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory
     */
    protected ConditionalAvailabilityCartConnectorFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factory = new ConditionalAvailabilityCartConnectorFactory();
    }

    /**
     * @return void
     */
    public function testGetService(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityCartConnectorService::class,
            $this->factory->getService(),
        );
    }
}
