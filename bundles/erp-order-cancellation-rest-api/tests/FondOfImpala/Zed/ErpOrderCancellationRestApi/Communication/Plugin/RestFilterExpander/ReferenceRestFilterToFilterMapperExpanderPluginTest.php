<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ReferenceRestFilterToFilterMapperExpanderPluginTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander\ReferenceRestFilterToFilterMapperExpanderPlugin
     */
    protected ReferenceRestFilterToFilterMapperExpanderPlugin $plugin;

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

        $this->plugin = new ReferenceRestFilterToFilterMapperExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $reference = 'reference';

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getReference')
            ->willReturn($reference);

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('addReference')
            ->with($reference)
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
    public function testExpandWithNoReference(): void
    {
        $reference = null;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getReference')
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
