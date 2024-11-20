<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DebitorNumberRestFilterToFilterMapperExpanderPluginTest extends Unit
{
    protected MockObject|RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransferMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected DebitorNumberRestFilterToFilterMapperExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->erpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new DebitorNumberRestFilterToFilterMapperExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $externalReference = 'externalReference';

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn($externalReference);

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('addDebitorNumber')
            ->with($externalReference)
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNoExternalReference(): void
    {
        $reference = null;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn($reference);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }
}
