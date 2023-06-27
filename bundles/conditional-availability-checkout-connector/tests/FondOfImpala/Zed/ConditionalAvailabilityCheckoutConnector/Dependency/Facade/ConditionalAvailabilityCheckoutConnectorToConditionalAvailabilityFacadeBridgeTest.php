<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityFacadeInterface|MockObject $facadeMock;

    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCriteriaFilterTransfer|MockObject $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @var (\ArrayObject&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ArrayObject|MockObject $arrayObjectMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge
     */
    protected ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arrayObjectMock = $this->getMockBuilder(ArrayObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedConditionalAvailabilities(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn($this->arrayObjectMock);

        static::assertEquals(
            $this->arrayObjectMock,
            $this->bridge->findGroupedConditionalAvailabilities(
                $this->conditionalAvailabilityCriteriaFilterTransferMock,
            ),
        );
    }
}
