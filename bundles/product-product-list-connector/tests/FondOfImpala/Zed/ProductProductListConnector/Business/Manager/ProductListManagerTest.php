<?php

namespace FondOfImpala\Zed\ProductProductListConnector\Business\Manager;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorEntityManagerInterface;
use FondOfImpala\Zed\ProductProductListConnector\Persistence\ProductProductListConnectorRepositoryInterface;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductListCollectionTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductListManagerTest extends Unit
{
    protected ProductProductListConnectorEntityManagerInterface|MockObject $entityManagerMock;

    protected ProductProductListConnectorRepositoryInterface|MockObject $repositoryMock;

    protected ProductConcreteTransfer|MockObject $productConcreteTransferMock;

    protected ProductListTransfer|MockObject $productListTransferMock;

    protected ProductListCollectionTransfer|MockObject $productListCollectionTransferMock;

    protected ProductListTransfer|MockObject $productListTransfer2Mock;

    protected ProductListTransfer|MockObject $productListTransfer3Mock;

    protected ProductListManager $manager;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->entityManagerMock = $this->getMockBuilder(ProductProductListConnectorEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ProductProductListConnectorRepositoryInterface::class)
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

        $this->productListCollectionTransferMock = $this->getMockBuilder(ProductListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new ProductListManager($this->repositoryMock, $this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testAddProductToProductListsEarlyExit(): void
    {
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductListCollection')->willReturn(null);
        $this->entityManagerMock->expects(static::never())->method('findOrCreateProductLists');
        $this->repositoryMock->expects(static::never())->method('findProductListsByProductRelation');
        $this->entityManagerMock->expects(static::never())->method('createProductToProductListRelation');
        $this->entityManagerMock->expects(static::never())->method('deleteProductToProductListRelation');

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
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

        $this->productListCollectionTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductListCollection')->willReturn($this->productListCollectionTransferMock);
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
        $this->productListCollectionTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductListCollection')->willReturn($this->productListCollectionTransferMock);
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
        $this->productListCollectionTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductListCollection')->willReturn($this->productListCollectionTransferMock);
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
        $this->productListCollectionTransferMock->expects(static::atLeastOnce())->method('getProductLists')->willReturn($productLists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getProductListCollection')->willReturn($this->productListCollectionTransferMock);
        $this->entityManagerMock->expects(static::atLeastOnce())->method('findOrCreateProductLists')->willReturn($productLists);
        $this->repositoryMock->expects(static::atLeastOnce())->method('findProductListsByProductRelation')->willReturn($productListsAlreadyExists);
        $this->productConcreteTransferMock->expects(static::atLeastOnce())->method('getIdProductConcrete')->willReturn($idProductConcrete);
        $this->entityManagerMock->expects(static::once())->method('createProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransferMock);
        $this->entityManagerMock->expects(static::once())->method('deleteProductToProductListRelation')->with($this->productConcreteTransferMock, $this->productListTransfer2Mock);

        $this->manager->addProductToProductLists($this->productConcreteTransferMock);
    }
}
