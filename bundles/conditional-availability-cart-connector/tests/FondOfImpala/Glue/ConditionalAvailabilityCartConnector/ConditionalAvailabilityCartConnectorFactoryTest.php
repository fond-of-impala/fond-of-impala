<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;

class ConditionalAvailabilityCartConnectorFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory
     */
    protected $conditionalAvailabilityCartConnectorFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorFactory = new ConditionalAvailabilityCartConnectorFactory();
    }

    /**
     * @return void
     */
    public function testGetService(): void
    {
        $this->assertInstanceOf(
            ConditionalAvailabilityCartConnectorServiceInterface::class,
            $this->conditionalAvailabilityCartConnectorFactory->getService(),
        );
    }
}
