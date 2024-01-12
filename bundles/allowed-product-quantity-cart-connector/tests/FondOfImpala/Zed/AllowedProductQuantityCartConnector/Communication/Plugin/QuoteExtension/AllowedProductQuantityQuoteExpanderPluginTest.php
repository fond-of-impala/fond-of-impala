<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;

class AllowedProductQuantityQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Communication\Plugin\QuoteExtension\AllowedProductQuantityQuoteExpanderPlugin
     */
    protected $allowedProductQuantityQuoteExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacade
     */
    protected $allowedProductQuantityCartConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityCartConnectorFacadeMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityQuoteExpanderPlugin = new AllowedProductQuantityQuoteExpanderPlugin();
        $this->allowedProductQuantityQuoteExpanderPlugin->setFacade($this->allowedProductQuantityCartConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->assertInstanceOf(QuoteTransfer::class, $this->allowedProductQuantityQuoteExpanderPlugin->expand($this->quoteTransferMock));
    }
}
