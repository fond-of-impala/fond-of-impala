<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class QuantityRestConditionalAvailabilityPeriodMapperPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    protected MockObject|RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransferMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension\QuantityRestConditionalAvailabilityPeriodMapperPlugin
     */
    protected QuantityRestConditionalAvailabilityPeriodMapperPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restConditionalAvailabilityPeriodTransferMock = $this
            ->getMockBuilder(RestConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new QuantityRestConditionalAvailabilityPeriodMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransfer(): void
    {
        $periodData = ['quantity' => 15];
        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('setQty')
            ->with($periodData['quantity'])
            ->willReturn($this->restConditionalAvailabilityPeriodTransferMock);

        $restConditionalAvailabilityPeriodTransfer = $this->plugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                $periodData,
                $this->restConditionalAvailabilityPeriodTransferMock,
            );

        static::assertEquals(
            $this->restConditionalAvailabilityPeriodTransferMock,
            $restConditionalAvailabilityPeriodTransfer,
        );
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransferWithInvalidData(): void
    {
        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::never())
            ->method('setQty');

        $restConditionalAvailabilityPeriodTransfer = $this->plugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                [],
                $this->restConditionalAvailabilityPeriodTransferMock,
            );

        static::assertEquals(
            $this->restConditionalAvailabilityPeriodTransferMock,
            $restConditionalAvailabilityPeriodTransfer,
        );
    }
}
