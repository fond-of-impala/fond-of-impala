<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    protected MockObject|RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface
     */
    protected MockObject|ErpOrderCancellationExpanderPluginInterface $erpOrderCancellationExpanderPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface
     */
    protected MockObject|ErpOrderCancellationExpanderPluginInterface $erpOrderCancellationExpanderPlugin2Mock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpander
     */
    protected ErpOrderCancellationExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restErpOrderCancellationRequestTransferMock = $this->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationExpanderPluginMock = $this->getMockBuilder(ErpOrderCancellationExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationExpanderPlugin2Mock = $this->getMockBuilder(ErpOrderCancellationExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @phpstan-ignore-next-line */
        $this->expander = new ErpOrderCancellationExpander([
            $this->erpOrderCancellationExpanderPluginMock,
            $this->erpOrderCancellationExpanderPlugin2Mock,
        ]);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->erpOrderCancellationExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationExpanderPlugin2Mock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->expander->expand($this->erpOrderCancellationTransferMock, $this->restErpOrderCancellationRequestTransferMock);
    }
}
