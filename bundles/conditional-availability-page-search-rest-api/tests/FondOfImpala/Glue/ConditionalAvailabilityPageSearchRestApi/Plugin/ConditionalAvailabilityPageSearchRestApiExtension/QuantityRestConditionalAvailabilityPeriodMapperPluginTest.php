<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class QuantityRestConditionalAvailabilityPeriodMapperPluginTest extends Unit
{
    /**
     * @var array
     */
    protected $periodData;

    /**
     * @var \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restConditionalAvailabilityPeriodTransferMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension\QuantityRestConditionalAvailabilityPeriodMapperPlugin
     */
    protected $quantityRestConditionalAvailabilityPeriodMapperPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->periodData = ['quantity' => 15];

        $this->restConditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(RestConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quantityRestConditionalAvailabilityPeriodMapperPlugin = new QuantityRestConditionalAvailabilityPeriodMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMapPeriodDataToRestConditionalAvailabilityPeriodTransfer(): void
    {
        $this->restConditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('setQty')
            ->with($this->periodData['quantity'])
            ->willReturn($this->restConditionalAvailabilityPeriodTransferMock);

        $restConditionalAvailabilityPeriodTransfer = $this->quantityRestConditionalAvailabilityPeriodMapperPlugin
            ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                $this->periodData,
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

        $restConditionalAvailabilityPeriodTransfer = $this->quantityRestConditionalAvailabilityPeriodMapperPlugin
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
