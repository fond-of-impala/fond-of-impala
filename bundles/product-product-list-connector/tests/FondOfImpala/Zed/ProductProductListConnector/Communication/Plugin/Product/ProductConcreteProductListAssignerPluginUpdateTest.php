<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Communication\Plugin\Product;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorFacade;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductConcreteProductListAssignerPluginUpdateTest extends Unit
{
    protected ProductProductListConnectorFacade|MockObject $facadeMock;

    protected ProductConcreteTransfer|MockObject $productConcreteTransferMock;

    protected ProductConcreteProductListAssignerPluginUpdate $plugin;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ProductProductListConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductConcreteProductListAssignerPluginUpdate();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())->method('updateProductToProductLists')->with($this->productConcreteTransferMock);
        $this->plugin->update($this->productConcreteTransferMock);
    }
}
