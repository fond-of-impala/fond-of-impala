<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilterInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedProductQuantityReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $allowedProductQuantityFacadeMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $abstractSkuFilterMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $allowedProductQuantityResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\AllowedProductQuantityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $allowedProductQuantityTransferMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReader
     */
    protected $allowedProductQuantityReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(
            AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface::class,
        )->disableOriginalConstructor()
            ->getMock();

        $this->abstractSkuFilterMock = $this->getMockBuilder(AbstractSkuFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(
            AllowedProductQuantityResponseTransfer::class,
        )->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(
            AllowedProductQuantityTransfer::class,
        )->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityReader = new AllowedProductQuantityReader(
            $this->abstractSkuFilterMock,
            $this->allowedProductQuantityFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByItem(): void
    {
        $idProductAbstract = 1;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->allowedProductQuantityFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->with(
                static::callback(
                    static fn (ProductAbstractTransfer $productAbstractTransfer): bool => $productAbstractTransfer->getIdProductAbstract() === $idProductAbstract,
                ),
            )->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getAllowedProductQuantityTransfer')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertEquals(
            $this->allowedProductQuantityTransferMock,
            $this->allowedProductQuantityReader->getByItem($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByItemWithoutIdProductAbstract(): void
    {
        $idProductAbstract = null;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->allowedProductQuantityFacadeMock->expects(static::never())
            ->method('findProductAbstractAllowedQuantity');

        static::assertEquals(
            null,
            $this->allowedProductQuantityReader->getByItem($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByItemWithoutResult(): void
    {
        $idProductAbstract = 1;

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->allowedProductQuantityFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->with(
                static::callback(
                    static fn (ProductAbstractTransfer $productAbstractTransfer): bool => $productAbstractTransfer->getIdProductAbstract() === $idProductAbstract,
                ),
            )->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects(static::atLeastOnce())
            ->method('getAllowedProductQuantityTransfer')
            ->willReturn(null);

        $this->allowedProductQuantityResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        static::assertEquals(
            null,
            $this->allowedProductQuantityReader->getByItem($this->itemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetGroupedByItems(): void
    {
        $abstractSkus = ['FOO-001-001'];
        $itemTransferMocks = new ArrayObject([$this->itemTransferMock]);
        $allowedProductQuantityTransferMocks = [$abstractSkus[0] => $this->allowedProductQuantityTransferMock];

        $this->abstractSkuFilterMock->expects(static::atLeastOnce())
            ->method('filterFromItems')
            ->with($itemTransferMocks)
            ->willReturn($abstractSkus);

        $this->allowedProductQuantityFacadeMock->expects(static::atLeastOnce())
            ->method('findGroupedProductAbstractAllowedQuantitiesByAbstractSkus')
            ->with($abstractSkus)
            ->willReturn($allowedProductQuantityTransferMocks);

        static::assertEquals(
            $allowedProductQuantityTransferMocks,
            $this->allowedProductQuantityReader->getGroupedByItems($itemTransferMocks),
        );
    }
}
