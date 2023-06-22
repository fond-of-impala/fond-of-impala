<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\ConditionalAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge
     */
    protected $facadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeBridge = new ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeBridge(
            $this->conditionalAvailabilityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testPersistConditionalAvailability(): void
    {
        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailability')
            ->with($this->conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $this->facadeBridge->persistConditionalAvailability($this->conditionalAvailabilityTransferMock),
        );
    }
}
