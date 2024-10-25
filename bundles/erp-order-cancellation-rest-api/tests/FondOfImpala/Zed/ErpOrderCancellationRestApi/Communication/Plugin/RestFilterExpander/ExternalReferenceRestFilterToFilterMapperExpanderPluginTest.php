<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ExternalReferenceRestFilterToFilterMapperExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander\ExternalReferenceRestFilterToFilterMapperExpanderPlugin
     */
    protected ExternalReferenceRestFilterToFilterMapperExpanderPlugin $plugin;

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
            ->getMockBuilder( RestErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ExternalReferenceRestFilterToFilterMapperExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $externalReference = 'externalReference';

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getExternalReference')
            ->willReturn($externalReference);

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('addExternalReference')
            ->with($externalReference)
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock
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
            ->method('getExternalReference')
            ->willReturn($reference);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock
            ),
        );
    }
}
