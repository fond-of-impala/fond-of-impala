<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\SplittableCheckoutOrderTypeConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderTypeOrderExpanderPreSavePluginTest extends Unit
{
    protected SpySalesOrderEntityTransfer|MockObject $spySalesOrderEntityTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected SplittableCheckoutOrderTypeConnectorFacade|MockObject $facadeMock;

    protected OrderTypeOrderExpanderPreSavePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->spySalesOrderEntityTransferMock = $this->getMockBuilder(SpySalesOrderEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(SplittableCheckoutOrderTypeConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderTypeOrderExpanderPreSavePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('expandSalesOrder')
            ->willReturn($this->spySalesOrderEntityTransferMock);

        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }
}
