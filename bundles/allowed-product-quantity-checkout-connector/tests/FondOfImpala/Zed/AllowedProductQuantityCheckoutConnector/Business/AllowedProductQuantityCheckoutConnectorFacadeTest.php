<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionChecker;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class AllowedProductQuantityCheckoutConnectorFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\AllowedProductQuantityCheckoutConnectorFacade
     */
    protected $allowedProductQuantityCheckoutConnectorFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    protected $checkoutResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\AllowedProductQuantityCheckoutConnectorBusinessFactory
     */
    protected $allowedProductQuantityCheckoutConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model\CheckoutPreConditionChecker
     */
    protected $checkoutPreConditionCheckerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityCheckoutConnectorBusinessFactoryMock = $this->getMockBuilder(AllowedProductQuantityCheckoutConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutPreConditionCheckerMock = $this->getMockBuilder(CheckoutPreConditionChecker::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCheckoutConnectorFacade = new AllowedProductQuantityCheckoutConnectorFacade();
        $this->allowedProductQuantityCheckoutConnectorFacade->setFactory($this->allowedProductQuantityCheckoutConnectorBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testCheckCheckoutPreCondition(): void
    {
        $this->allowedProductQuantityCheckoutConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCheckoutPreConditionChecker')
            ->willReturn($this->checkoutPreConditionCheckerMock);

        $this->checkoutPreConditionCheckerMock->expects($this->atLeastOnce())
            ->method('check')
            ->willReturn(true);

        $this->assertTrue($this->allowedProductQuantityCheckoutConnectorFacade->checkCheckoutPreCondition($this->quoteTransferMock, $this->checkoutResponseTransferMock));
    }
}
