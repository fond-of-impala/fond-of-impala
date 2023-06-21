<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;

class ConditionalAvailabilityPageSearchConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig
     */
    protected $conditionalAvailabilityPageSearchConfig;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityPageSearchConfig = new ConditionalAvailabilityPageSearchConfig();
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityPeriodSynchronizationPoolName(): void
    {
        $this->assertNull(
            $this->conditionalAvailabilityPageSearchConfig->getConditionalAvailabilityPeriodSynchronizationPoolName(),
        );
    }

    /**
     * @return void
     */
    public function testIsSendingToQueue(): void
    {
        $this->assertTrue(
            $this->conditionalAvailabilityPageSearchConfig->isSendingToQueue(),
        );
    }
}
