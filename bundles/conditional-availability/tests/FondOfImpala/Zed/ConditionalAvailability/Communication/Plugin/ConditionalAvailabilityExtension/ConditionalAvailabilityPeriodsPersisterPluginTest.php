<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Communication\Plugin\ConditionalAvailabilityExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPeriodsPersisterPluginTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransferMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityFacade|MockObject $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Communication\Plugin\ConditionalAvailabilityExtension\ConditionalAvailabilityPeriodsPersisterPlugin
     */
    protected ConditionalAvailabilityPeriodsPersisterPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityPeriodsPersisterPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostSaveWithInvalidConditionalAvailabilityResponseTransfer(): void
    {
        $this->conditionalAvailabilityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn(null);

        $conditionalAvailabilityResponseTransfer = $this->plugin->postSave(
            $this->conditionalAvailabilityResponseTransferMock,
        );

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $conditionalAvailabilityResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testPostSave(): void
    {
        $conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->conditionalAvailabilityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn($conditionalAvailabilityTransferMock);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('persistConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityResponseTransferMock->expects(static::atLeastOnce())
            ->method('setConditionalAvailabilityTransfer')
            ->with($conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $conditionalAvailabilityResponseTransfer = $this->plugin->postSave(
            $this->conditionalAvailabilityResponseTransferMock,
        );

        static::assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $conditionalAvailabilityResponseTransfer,
        );
    }
}
