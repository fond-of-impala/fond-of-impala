<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductAbstractAllowedQuantityReaderTest extends Unit
{
    protected MockObject|AllowedProductQuantityRepositoryInterface $repositoryMock;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    private MockObject|AllowedProductQuantityTransfer $allowedProductQuantityTransferMock;

    protected ProductAbstractAllowedQuantityReader $productAbstractAllowedQuantityReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(AllowedProductQuantityRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractAllowedQuantityReader = new ProductAbstractAllowedQuantityReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testFindByIdProductAbstract(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('requireIdProductAbstract')
            ->willReturn($this->productAbstractTransferMock);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findAllowedProductQuantityByIdProductAbstract')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $allowedProductQuantityResponseTransfer = $this->productAbstractAllowedQuantityReader
            ->findByIdProductAbstract($this->productAbstractTransferMock);

        static::assertTrue($allowedProductQuantityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            $this->allowedProductQuantityTransferMock,
            $allowedProductQuantityResponseTransfer->getAllowedProductQuantityTransfer(),
        );
    }

    /**
     * @return void
     */
    public function testFindByIdProductAbstractAllowedProductQuantityTransferNull(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('requireIdProductAbstract')
            ->willReturn($this->productAbstractTransferMock);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(2);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findAllowedProductQuantityByIdProductAbstract')
            ->willReturn(null);

        $allowedProductQuantityResponseTransfer = $this->productAbstractAllowedQuantityReader
            ->findByIdProductAbstract($this->productAbstractTransferMock);

        static::assertFalse($allowedProductQuantityResponseTransfer->getIsSuccessful());
        static::assertEquals(
            null,
            $allowedProductQuantityResponseTransfer->getAllowedProductQuantityTransfer(),
        );
    }
}
