<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityCheckoutPreConditionPluginTest extends Unit
{
    protected AllowedProductQuantityCheckoutPreConditionPlugin $allowedProductQuantityCheckoutPreConditionPlugin;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|CheckoutResponseTransfer $checkoutResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCheckoutPreConditionPlugin = new AllowedProductQuantityCheckoutPreConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckCondition(): void
    {
        $this->assertTrue($this->allowedProductQuantityCheckoutPreConditionPlugin->checkCondition($this->quoteTransferMock, $this->checkoutResponseTransferMock));
    }
}
