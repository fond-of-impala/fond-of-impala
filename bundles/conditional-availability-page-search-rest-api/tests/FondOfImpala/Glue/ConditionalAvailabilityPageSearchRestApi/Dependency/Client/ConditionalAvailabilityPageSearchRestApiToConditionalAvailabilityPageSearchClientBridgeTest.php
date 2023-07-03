<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClientInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client\ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientBridge
     */
    protected ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientBridge $conditionalAvailabilityPageSearchClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClientInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityPageSearchClientMock = $this
            ->getMockBuilder(ConditionalAvailabilityPageSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchClientBridge = new ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientBridge(
            $this->conditionalAvailabilityPageSearchClientMock,
        );
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $searchString = 'search-string';

        $this->conditionalAvailabilityPageSearchClientMock->expects(static::atLeastOnce())
            ->method('search')
            ->with($searchString, [])
            ->willReturn([]);

        static::assertEquals([], $this->conditionalAvailabilityPageSearchClientBridge->search($searchString));
    }
}
