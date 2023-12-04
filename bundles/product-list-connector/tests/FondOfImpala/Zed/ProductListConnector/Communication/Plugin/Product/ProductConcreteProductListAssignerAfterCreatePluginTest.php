<?php

namespace FondOfImpala\Zed\ProductListConnector\Communication\Plugin\Product;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorFacade;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductConcreteProductListAssignerAfterCreatePluginTest extends Unit
{
    protected ProductListConnectorFacade|MockObject $facadeMock;

    protected ProductConcreteTransfer|MockObject $productConcreteTransferMock;

    protected ProductConcreteProductListAssignerAfterCreatePlugin $plugin;

    /**
     * @return void
     */
    public function _before()
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ProductListConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductConcreteProductListAssignerAfterCreatePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())->method('addProductToProductLists')->with($this->productConcreteTransferMock);
        $this->plugin->create($this->productConcreteTransferMock);
    }
}
