<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityReaderInterface;
use FondOfImpala\Zed\AllowedProductQuantity\Business\Model\ProductAbstractAllowedQuantityWriterInterface;
use FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepository;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityFacadeTest extends Unit
{
    protected MockObject|AllowedProductQuantityBusinessFactory $factoryMock;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    protected MockObject|ProductAbstractAllowedQuantityWriterInterface $productAbstractAllowedQuantityWriterMock;

    protected MockObject|ProductAbstractAllowedQuantityReaderInterface $productAbstractAllowedQuantityReaderMock;

    protected MockObject|AllowedProductQuantityResponseTransfer $allowedProductQuantityResponseTransferMock;

    protected AllowedProductQuantityTransfer|MockObject $allowedProductQuantityTransferMock;

    protected AllowedProductQuantityRepository|MockObject $repositoryMock;

    protected AllowedProductQuantityFacade $allowedProductQuantityFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(AllowedProductQuantityBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractAllowedQuantityWriterMock = $this->getMockBuilder(ProductAbstractAllowedQuantityWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractAllowedQuantityReaderMock = $this->getMockBuilder(ProductAbstractAllowedQuantityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(AllowedProductQuantityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(AllowedProductQuantityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityFacade = new AllowedProductQuantityFacade();
        $this->allowedProductQuantityFacade->setFactory($this->factoryMock);
        $this->allowedProductQuantityFacade->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testPersistProductAbstractAllowedQuantity(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductAbstractAllowedQuantityWriter')
            ->willReturn($this->productAbstractAllowedQuantityWriterMock);

        $this->productAbstractAllowedQuantityWriterMock->expects(static::atLeastOnce())
            ->method('persist')
            ->willReturn($this->productAbstractTransferMock);

        static::assertEquals(
            $this->productAbstractTransferMock,
            $this->allowedProductQuantityFacade->persistProductAbstractAllowedQuantity(
                $this->productAbstractTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindProductAbstractAllowedQuantity(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductAbstractAllowedQuantityReader')
            ->willReturn($this->productAbstractAllowedQuantityReaderMock);

        $this->productAbstractAllowedQuantityReaderMock->expects(static::atLeastOnce())
            ->method('findByIdProductAbstract')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        static::assertEquals(
            $this->allowedProductQuantityResponseTransferMock,
            $this->allowedProductQuantityFacade->findProductAbstractAllowedQuantity($this->productAbstractTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedProductAbstractAllowedQuantitiesByAbstractSkus(): void
    {
        $abstractSkus = ['FOO-001-001', 'FOO-001-002'];
        $groupedProductAbstractAllowedQuantities = [$abstractSkus[0] => $this->allowedProductQuantityTransferMock];

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findGroupedAllowedProductQuantitiesByAbstractSkus')
            ->with($abstractSkus)
            ->willReturn($groupedProductAbstractAllowedQuantities);

        static::assertEquals(
            $groupedProductAbstractAllowedQuantities,
            $this->allowedProductQuantityFacade->findGroupedProductAbstractAllowedQuantitiesByAbstractSkus(
                $abstractSkus,
            ),
        );
    }
}
