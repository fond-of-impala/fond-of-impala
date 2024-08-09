<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander\SalesOrderExpanderInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SplittableCheckoutOrderTypeConnectorFacadeTest extends Unit
{
    protected SplittableCheckoutOrderTypeConnectorBusinessFactory|MockObject $factoryMock;

    protected RestSplittableCheckoutRequestTransfer|MockObject $restSplittableCheckoutRequestTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected SpySalesOrderEntityTransfer|MockObject $spySalesOrderEntityTransferMock;

    protected QuoteExpanderInterface|MockObject $quoteExpanderMock;

    protected SalesOrderExpanderInterface|MockObject $salesOrderExpanderMock;

    protected SplittableCheckoutOrderTypeConnectorFacade $facade;

    /**
     * @Override
     *
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(SplittableCheckoutOrderTypeConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restSplittableCheckoutRequestTransferMock = $this->getMockBuilder(RestSplittableCheckoutRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderEntityTransferMock = $this->getMockBuilder(SpySalesOrderEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpanderMock = $this->getMockBuilder(QuoteExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderExpanderMock = $this->getMockBuilder(SalesOrderExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new SplittableCheckoutOrderTypeConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuote(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteExpander')
            ->willReturn($this->quoteExpanderMock);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->quoteTransferMock);

        $this->facade->expandQuote($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTypesQuote(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteExpander')
            ->willReturn($this->quoteExpanderMock);

        $this->quoteExpanderMock->expects(static::atLeastOnce())
            ->method('expandTypes')
            ->willReturn($this->quoteTransferMock);

        $this->facade->expandTypesQuote($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandSalesOrder(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createSalesOrderExpander')
            ->willReturn($this->salesOrderExpanderMock);

        $this->salesOrderExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->spySalesOrderEntityTransferMock);

        $this->facade->expandSalesOrder($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }
}
