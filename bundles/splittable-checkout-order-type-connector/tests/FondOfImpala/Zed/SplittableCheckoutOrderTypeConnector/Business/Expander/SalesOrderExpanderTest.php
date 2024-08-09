<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SalesOrderExpanderTest extends Unit
{
    protected OrderTypeValidatorInterface|MockObject $orderTypeValidatorMock;

    protected SplittableCheckoutOrderTypeConnectorConfig|MockObject $configMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected SpySalesOrderEntityTransfer|MockObject $spySalesOrderEntityTransferMock;

    protected SalesOrderExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->orderTypeValidatorMock = $this->getMockBuilder(OrderTypeValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(SplittableCheckoutOrderTypeConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderEntityTransferMock = $this->getMockBuilder(SpySalesOrderEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new SalesOrderExpander($this->orderTypeValidatorMock, $this->configMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $orderType = 'pre';

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn($orderType);

        $this->orderTypeValidatorMock
            ->expects(static::atLeastOnce())
            ->method('validateOrderType')
            ->willReturn(true);

        $this->spySalesOrderEntityTransferMock
            ->expects(static::atLeastOnce())
            ->method('setOrderType')
            ->with($orderType)
            ->willReturnSelf();

        $this->expander->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandNullAllowed(): void
    {
        $orderType = null;

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn($orderType);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getAllowEmptyOrderType')
            ->willReturn(true);

        $this->spySalesOrderEntityTransferMock
            ->expects(static::atLeastOnce())
            ->method('setOrderType')
            ->with($orderType)
            ->willReturnSelf();

        $this->expander->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandNullNotAllowed(): void
    {
        $orderType = null;

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn($orderType);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getAllowEmptyOrderType')
            ->willReturn(false);

        try {
            $this->expander->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
        } catch (Exception $e) {
            static::assertEquals('Order type is required', $e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testExpandTypeIsInvalid(): void
    {
        $orderType = 'test';

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn($orderType);

        $this->orderTypeValidatorMock
            ->expects(static::atLeastOnce())
            ->method('validateOrderType')
            ->willReturn(false);

        try {
            $this->expander->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
        } catch (Exception $e) {
            static::assertEquals(sprintf('Order type "%s" is not valid', $orderType), $e->getMessage());
        }
    }
}
