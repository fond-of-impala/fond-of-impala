<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\ProductListsBulkRestApiFacade;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListRestProductListsBulkRequestExpanderPluginTest extends Unit
{
    protected MockObject|ProductListsBulkRestApiFacade $facadeMock;

    protected ProductListRestProductListsBulkRequestExpanderPlugin $plugin;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restProductListsBulkRequestTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ProductListsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductListRestProductListsBulkRequestExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->plugin->expand($this->restProductListsBulkRequestTransferMock),
        );
    }
}
