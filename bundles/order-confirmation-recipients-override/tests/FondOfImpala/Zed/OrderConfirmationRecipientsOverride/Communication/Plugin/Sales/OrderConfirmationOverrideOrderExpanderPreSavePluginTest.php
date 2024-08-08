<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderConfirmationOverrideOrderExpanderPreSavePluginTest extends Unit
{
    protected SpySalesOrderEntityTransfer|MockObject $spySalesOrderEntityTransferMock;

    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected OrderConfirmationOverrideOrderExpanderPreSavePlugin $plugin;

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

        $this->plugin = new OrderConfirmationOverrideOrderExpanderPreSavePlugin();
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturn(true);

        $this->spySalesOrderEntityTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMail')
            ->with(true)
            ->willReturnSelf();

        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandFalse(): void
    {
        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturn(false);

        $this->spySalesOrderEntityTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMail')
            ->with(false)
            ->willReturnSelf();

        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandNullFalse(): void
    {
        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getPreventCustomerOrderConfirmationMail')
            ->willReturn(null);

        $this->spySalesOrderEntityTransferMock
            ->expects(static::atLeastOnce())
            ->method('setPreventCustomerOrderConfirmationMail')
            ->with(false)
            ->willReturnSelf();

        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }
}
