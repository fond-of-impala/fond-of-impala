<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConstants;

class ConditionalAvailabilityCompanyConnectorConfigTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConfig
     */
    protected ConditionalAvailabilityCompanyConnectorConfig $config;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->config = $this->getMockBuilder(ConditionalAvailabilityCompanyConnectorConfig::class)
            ->onlyMethods(['get'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testGetDefaultAvailabilityChannel(): void
    {
        $availabilityChannel = 'availability-channel';
        $this->config->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityCompanyConnectorConstants::DEFAULT_AVAILABILITY_CHANNEL)
            ->willReturn($availabilityChannel);

        static::assertEquals(
            $availabilityChannel,
            $this->config->getDefaultAvailabilityChannel(),
        );
    }
}
