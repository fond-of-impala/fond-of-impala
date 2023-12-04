<?php

namespace FondOfImpala\Zed\ProductListConnector\Business\Manager;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorEntityManagerInterface;
use FondOfImpala\Zed\ProductListConnector\Persistence\ProductListConnectorRepositoryInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListManagerTest extends Unit
{
    protected ProductListConnectorEntityManagerInterface|MockObject $entityManagerMock;

    protected ProductListConnectorRepositoryInterface|MockObject $repositoryMock;

    protected ProductConcreteTransfer|MockObject $productConcreteTransferMock;

    protected ProductListTransfer|MockObject $productListTransferMock;

    protected ProductListTransfer|MockObject $productListTransfer2Mock;

    protected ProductListTransfer|MockObject $productListTransfer3Mock;

    protected ProductListManager $manager;

    /**
     * @return void
     */
    public function _before()
    {
        parent::_before();

        $this->entityManagerMock = $this->getMockBuilder(ProductListConnectorEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ProductListConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListTransferMock = $this->getMockBuilder(ProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListTransfer2Mock = $this->getMockBuilder(ProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListTransfer3Mock = $this->getMockBuilder(ProductListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new ProductListManager($this->repositoryMock, $this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testAddProductToProductListsDoNothing(): void
    {
        $productLists = new ArrayObject();
        $productListsCreated = new ArrayObject();
        $productListsAlreadyExists = new ArrayObject();
        $idProductConcrete = 1;

        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->entityManagerMock->expects(static::atLeastOnce())->method('findOrCreateProductLists')->willReturn($productListsCreated);
        $this->repositoryMock->expects(static::atLeastOnce())->method('findProductListsByProductRelation')->willReturn($productListsAlreadyExists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getIdProductConcrete')->willReturn($idProductConcrete);
        $this->entityManagerMock->expects(static::never())->method('createProductToProductListRelation');
        $this->entityManagerMock->expects(static::never())->method('deleteProductToProductListRelation');

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testAddProductToProductListsCreateOnly(): void
    {
        $productListKey = 'k-e-y';
        $productLists = new ArrayObject([$productListKey => $this->productListTransferMock]);
        $productListsAlreadyExists = new ArrayObject();
        $idProductConcrete = 1;

        $this->productListTransferMock->expects(static::atLeastOnce())->method('getKey')->willReturn($productListKey);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->entityManagerMock->expects(static::atLeastOnce())->method('findOrCreateProductLists')->willReturn($productLists);
        $this->repositoryMock->expects(static::atLeastOnce())->method('findProductListsByProductRelation')->willReturn($productListsAlreadyExists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getIdProductConcrete')->willReturn($idProductConcrete);
        $this->entityManagerMock->expects(static::once())->method('createProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransferMock);
        $this->entityManagerMock->expects(static::never())->method('deleteProductToProductListRelation');

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateProductToProductListsWithCreateAndDelete(): void
    {
        $productListKey = 'k-e-y';
        $productListKey2 = 'k-e-y2';
        $productLists = new ArrayObject([$productListKey => $this->productListTransferMock]);
        $productListsAlreadyExists = new ArrayObject([$productListKey2 => $this->productListTransfer2Mock]);
        $idProductConcrete = 1;

        $this->productListTransferMock->expects(static::atLeastOnce())->method('getKey')->willReturn($productListKey);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->entityManagerMock->expects(static::atLeastOnce())->method('findOrCreateProductLists')->willReturn($productLists);
        $this->repositoryMock->expects(static::atLeastOnce())->method('findProductListsByProductRelation')->willReturn($productListsAlreadyExists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getIdProductConcrete')->willReturn($idProductConcrete);
        $this->entityManagerMock->expects(static::once())->method('createProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransferMock);
        $this->entityManagerMock->expects(static::once())->method('deleteProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransfer2Mock);

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateProductToProductListsWithCreateIgnoreAndDelete(): void
    {
        $productListKey = 'k-e-y';
        $productListKey2 = 'k-e-y2';
        $productListKey3 = 'k-e-y3';
        $productLists = new ArrayObject(
            [
                $productListKey => $this->productListTransferMock,
                $productListKey3 => $this->productListTransfer3Mock,
            ],
        );
        $productListsAlreadyExists = new ArrayObject(
            [
                $productListKey2 => $this->productListTransfer2Mock,
                $productListKey3 => $this->productListTransfer3Mock,
            ],
        );
        $idProductConcrete = 1;

        $this->productListTransferMock->expects(static::atLeastOnce())->method('getKey')->willReturn($productListKey);
        $this->productListTransfer3Mock->expects(static::atLeastOnce())->method('getKey')->willReturn($productListKey3);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->entityManagerMock->expects(static::atLeastOnce())->method('findOrCreateProductLists')->willReturn($productLists);
        $this->repositoryMock->expects(static::atLeastOnce())->method('findProductListsByProductRelation')->willReturn($productListsAlreadyExists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getIdProductConcrete')->willReturn($idProductConcrete);
        $this->entityManagerMock->expects(static::once())->method('createProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransferMock);
        $this->entityManagerMock->expects(static::once())->method('deleteProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransfer2Mock);

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
    }
}
