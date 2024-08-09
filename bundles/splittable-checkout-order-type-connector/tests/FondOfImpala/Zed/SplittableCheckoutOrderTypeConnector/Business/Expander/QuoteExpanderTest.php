<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Throwable;

class QuoteExpanderTest extends Unit
{
    protected OrderTypeValidatorInterface|MockObject $orderTypeValidatorMock;

    protected SplittableCheckoutOrderTypeConnectorConfig|MockObject $configMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected RestSplittableCheckoutRequestTransfer|MockObject $restSplittableCheckoutRequestTransferMock;

    protected QuoteExpander $expander;

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

        $this->restSplittableCheckoutRequestTransferMock = $this->getMockBuilder(RestSplittableCheckoutRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new QuoteExpander($this->orderTypeValidatorMock, $this->configMock);
    }

    /**
     * @return void
     */
    public function testExpandAndDoNothing(): void
    {
        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn(null);

        $this->expander->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderType')
            ->willReturn('pre');

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setOrderType')
            ->with('pre')
            ->willReturnSelf();

        $this->expander->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTypesNullAllowed(): void
    {
        $orderTypes = ['pre', 'daily', null, ''];

        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderTypes')
            ->willReturn($orderTypes);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getAllowEmptyOrderType')
            ->willReturn(true);

        $this->orderTypeValidatorMock
            ->expects(static::atLeastOnce())
            ->method('validateOrderType')
            ->willReturnOnConsecutiveCalls(true, true);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setOrderTypes')
            ->with($orderTypes)
            ->willReturnSelf();

        $this->expander->expandTypes($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandTypesNullNotAllowed(): void
    {
        $orderTypes = ['pre', 'daily', null];

        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderTypes')
            ->willReturn($orderTypes);

        $this->configMock
            ->expects(static::atLeastOnce())
            ->method('getAllowEmptyOrderType')
            ->willReturn(false);

        $this->orderTypeValidatorMock
            ->expects(static::atLeastOnce())
            ->method('validateOrderType')
            ->willReturnOnConsecutiveCalls(true, true, false);

        try {
            $this->expander->expandTypes($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
        } catch (Throwable $e) {
            static::assertSame('Order type "EMPTY" is not valid', $e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testExpandTypesInvalid(): void
    {
        $orderTypes = ['invalid'];

        $this->restSplittableCheckoutRequestTransferMock
            ->expects(static::atLeastOnce())
            ->method('getOrderTypes')
            ->willReturn($orderTypes);

        $this->orderTypeValidatorMock
            ->expects(static::atLeastOnce())
            ->method('validateOrderType')
            ->willReturnOnConsecutiveCalls(false);

        try {
            $this->expander->expandTypes($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock);
        } catch (Throwable $e) {
            static::assertSame('Order type "invalid" is not valid', $e->getMessage());
        }
    }
}
