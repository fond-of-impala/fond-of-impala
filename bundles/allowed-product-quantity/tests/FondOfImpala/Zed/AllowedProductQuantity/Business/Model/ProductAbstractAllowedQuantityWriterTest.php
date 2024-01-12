<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityEntityManagerInterface;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class ProductAbstractAllowedQuantityWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityEntityManagerInterface
     */
    protected $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    protected $allowedProductQuantityTransferMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityWriter
     */
    protected $productAbstractAllowedQuantityWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->entityManagerMock = $this->getMockBuilder(AllowedProductQuantityEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractAllowedQuantityWriter = new ProductAbstractAllowedQuantityWriter($this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testPersist(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAllowedQuantity')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('persistAllowedProductQuantity')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('setAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        static::assertEquals(
            $this->productAbstractTransferMock,
            $this->productAbstractAllowedQuantityWriter->persist($this->productAbstractTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistIdProductAbstractNull(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAllowedQuantity')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(null);

        $this->productAbstractTransferMock->expects(static::atLeast(2))
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('setIdProductAbstract')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('persistAllowedProductQuantity')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('setAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        static::assertEquals(
            $this->productAbstractTransferMock,
            $this->productAbstractAllowedQuantityWriter->persist($this->productAbstractTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPersistProductAbstractTransferNull(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAllowedQuantity')
            ->willReturn(null);

        static::assertEquals(
            $this->productAbstractTransferMock,
            $this->productAbstractAllowedQuantityWriter->persist($this->productAbstractTransferMock),
        );
    }
}
