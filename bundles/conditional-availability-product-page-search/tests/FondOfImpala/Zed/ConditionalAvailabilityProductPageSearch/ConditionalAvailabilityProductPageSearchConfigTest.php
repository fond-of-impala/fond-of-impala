<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch;

use Codeception\Test\Unit;

class ConditionalAvailabilityProductPageSearchConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConfig
     */
    protected ConditionalAvailabilityProductPageSearchConfig $config;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->config = new ConditionalAvailabilityProductPageSearchConfig();
    }

    /**
     * @return void
     */
    public function testGetEventQueueName(): void
    {
        static::assertNull($this->config->getEventQueueName());
    }
}
