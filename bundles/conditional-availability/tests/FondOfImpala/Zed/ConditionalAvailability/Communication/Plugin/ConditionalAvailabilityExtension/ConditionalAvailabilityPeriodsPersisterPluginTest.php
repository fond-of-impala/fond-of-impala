<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Communication\Plugin\ConditionalAvailabilityExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;

class ConditionalAvailabilityPeriodsPersisterPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Communication\Plugin\ConditionalAvailabilityExtension\ConditionalAvailabilityPeriodsPersisterPlugin
     */
    protected $conditionalAvailabilityPeriodsPersisterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacade
     */
    protected $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected $conditionalAvailabilityResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityResponseTransferMock = $this->getMockBuilder(ConditionalAvailabilityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodsPersisterPlugin = new ConditionalAvailabilityPeriodsPersisterPlugin();

        $this->conditionalAvailabilityPeriodsPersisterPlugin->setFacade($this->conditionalAvailabilityFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostSaveWithInvalidConditionalAvailabilityResponseTransfer(): void
    {
        $this->conditionalAvailabilityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn(null);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityPeriodsPersisterPlugin->postSave(
            $this->conditionalAvailabilityResponseTransferMock,
        );

        $this->assertEquals(
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

        $this->conditionalAvailabilityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->conditionalAvailabilityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getConditionalAvailabilityTransfer')
            ->willReturn($conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityFacadeMock->expects($this->atLeastOnce())
            ->method('persistConditionalAvailabilityPeriods')
            ->willReturn($conditionalAvailabilityTransferMock);

        $this->conditionalAvailabilityResponseTransferMock->expects($this->atLeastOnce())
            ->method('setConditionalAvailabilityTransfer')
            ->with($conditionalAvailabilityTransferMock)
            ->willReturn($this->conditionalAvailabilityResponseTransferMock);

        $conditionalAvailabilityResponseTransfer = $this->conditionalAvailabilityPeriodsPersisterPlugin->postSave(
            $this->conditionalAvailabilityResponseTransferMock,
        );

        $this->assertEquals(
            $this->conditionalAvailabilityResponseTransferMock,
            $conditionalAvailabilityResponseTransfer,
        );
    }
}
