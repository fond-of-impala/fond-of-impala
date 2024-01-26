<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Communication\Plugin\QuoteExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityQuoteExpanderPluginTest extends Unit
{
    protected AllowedProductQuantityQuoteExpanderPlugin $allowedProductQuantityQuoteExpanderPlugin;

    protected MockObject|AllowedProductQuantityCartConnectorFacade $allowedProductQuantityCartConnectorFacadeMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

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
