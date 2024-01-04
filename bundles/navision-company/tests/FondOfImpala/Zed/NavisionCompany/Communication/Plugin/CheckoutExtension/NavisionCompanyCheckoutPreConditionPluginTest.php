<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CheckoutExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\NavisionCompany\NavisionCompanyConstants;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class NavisionCompanyCheckoutPreConditionPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CheckoutResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $checkoutResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CheckoutExtension\NavisionCompanyCheckoutPreConditionPlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new NavisionCompanyCheckoutPreConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckCondition(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIsBlocked')
            ->willReturn(true);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturn($this->checkoutResponseTransferMock);

        $this->checkoutResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static fn (CheckoutErrorTransfer $checkoutErrorTransfer): bool => $checkoutErrorTransfer->getMessage() === NavisionCompanyConstants::MESSAGE_COMPANY_IS_BLOCKED,
                ),
            )->willReturn($this->checkoutResponseTransferMock);

        static::assertFalse(
            $this->plugin->checkCondition($this->quoteTransferMock, $this->checkoutResponseTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCheckConditionWithoutCompanyUser(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('setIsSuccess');

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('addError');

        static::assertTrue(
            $this->plugin->checkCondition($this->quoteTransferMock, $this->checkoutResponseTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCheckConditionWithoutCompany(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('setIsSuccess');

        $this->checkoutResponseTransferMock->expects(static::never())
            ->method('addError');

        static::assertTrue(
            $this->plugin->checkCondition($this->quoteTransferMock, $this->checkoutResponseTransferMock),
        );
    }
}
