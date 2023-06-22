<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer
     */
    protected $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge
     */
    protected $conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge = new ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge(
            $this->conditionalAvailabilityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedConditionalAvailabilities(): void
    {
        $groupedConditionalAvailabilities = new ArrayObject([]);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($groupedConditionalAvailabilities);

        static::assertEquals(
            $groupedConditionalAvailabilities,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge->findGroupedConditionalAvailabilities(
                $this->conditionalAvailabilityCriteriaFilterTransferMock,
            ),
        );
    }
}
