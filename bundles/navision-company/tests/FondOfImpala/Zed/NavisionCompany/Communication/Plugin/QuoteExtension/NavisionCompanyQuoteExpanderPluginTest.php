<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\NavisionCompany\NavisionCompanyConstants;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class NavisionCompanyQuoteExpanderPluginTest extends Unit
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
     * @var \FondOfImpala\Zed\NavisionCompany\Communication\Plugin\QuoteExtension\NavisionCompanyQuoteExpanderPlugin
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

        $this->plugin = new NavisionCompanyQuoteExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
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

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with(
                static::callback(
                    static fn (MessageTransfer $messageTransfer): bool => $messageTransfer->getType() === NavisionCompanyConstants::MESSAGE_TYPE_ERROR
                        && $messageTransfer->getValue() === NavisionCompanyConstants::MESSAGE_COMPANY_IS_BLOCKED,
                ),
            )->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutCompanyUser(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::never())
            ->method('addValidationMessage');

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutCompany(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::never())
            ->method('addValidationMessage');

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock),
        );
    }
}
