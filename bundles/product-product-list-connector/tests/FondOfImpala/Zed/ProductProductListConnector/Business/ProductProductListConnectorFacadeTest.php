<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManagerInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductProductListConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorBusinessFactory
     */
    protected MockObject|ProductProductListConnectorBusinessFactory $productListConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductProductListConnector\Business\Manager\ProductListManagerInterface
     */
    protected MockObject|ProductListManagerInterface $productListManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \FondOfImpala\Zed\ProductProductListConnector\Business\ProductProductListConnectorFacadeInterface
     */
    protected ProductProductListConnectorFacadeInterface $productListConnectorFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productListConnectorBusinessFactoryMock = $this->getMockBuilder(ProductProductListConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListManagerMock = $this->getMockBuilder(ProductListManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorFacade = new ProductProductListConnectorFacade();

        $this->productListConnectorFacade->setFactory($this->productListConnectorBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddProductToProductLists(): void
    {
        $this->productListConnectorBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListManager')
            ->willReturn($this->productListManagerMock);

        $this->productListManagerMock->expects(static::atLeastOnce())
            ->method('addProductToProductLists')
            ->with($this->productConcreteTransferMock);

        $this->productListConnectorFacade->addProductToProductLists(
            $this->productConcreteTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateProductToProductLists(): void
    {
        $this->productListConnectorBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createProductListManager')
            ->willReturn($this->productListManagerMock);

        $this->productListManagerMock->expects(static::atLeastOnce())
            ->method('updateProductToProductLists')
            ->with($this->productConcreteTransferMock);

        $this->productListConnectorFacade->updateProductToProductLists(
            $this->productConcreteTransferMock,
        );
    }
}
