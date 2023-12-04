<?php

namespace FondOfImpala\Zed\ProductListConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConnector\Business\Manager\ProductListManagerInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorBusinessFactory
     */
    protected MockObject|ProductListConnectorBusinessFactory $productListConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorBusinessFactory
     */
    protected MockObject|ProductListManagerInterface $productListManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorBusinessFactory
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \FondOfImpala\Zed\ProductListConnector\Business\ProductListConnectorFacadeInterface
     */
    protected ProductListConnectorFacadeInterface $productListConnectorFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productListConnectorBusinessFactoryMock = $this->getMockBuilder(ProductListConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListManagerMock = $this->getMockBuilder(ProductListManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConnectorFacade = new ProductListConnectorFacade();

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
