<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\WebUiSettings\WebUiSettingsConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class QuoteExpanderTest extends Unit
{
    protected QuoteTransfer|MockObject $quoteTransferMock;

    protected CustomerTransfer|MockObject $customerTransferMock;

    protected WebUiSettingsTransfer|MockObject $webUiSettingsTransferMock;

    protected WebUiSettingsConfig|MockObject $configMock;

    protected QuoteExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->webUiSettingsTransferMock = $this->getMockBuilder(WebUiSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(WebUiSettingsConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new QuoteExpander($this->configMock);
    }

    /**
     * @return void
     */
    public function testExpandViewFromQuote(): void
    {
        $view = 'list';

        $this->quoteTransferMock->expects(static::never())
            ->method('setView');

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getView')
            ->willReturn($view);

        $this->expander->expand($this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandViewFromCustomer(): void
    {
        $view = 'list';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setView')
            ->with($view)
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getView')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getDefaultCartView')
            ->willReturn($view);

        $this->expander->expand($this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandViewFromConfig(): void
    {
        $view = 'list';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setView')
            ->with($view)
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getView')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getWebUiSettings')
            ->willReturn($this->webUiSettingsTransferMock);

        $this->webUiSettingsTransferMock->expects(static::atLeastOnce())
            ->method('getDefaultCartView')
            ->willReturn(null);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getFallbackView')
            ->willReturn($view);

        $this->expander->expand($this->quoteTransferMock);
    }
}
