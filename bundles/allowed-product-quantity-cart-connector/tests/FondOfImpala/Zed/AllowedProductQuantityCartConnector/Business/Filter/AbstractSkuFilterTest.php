<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;

class AbstractSkuFilterTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Filter\AbstractSkuFilter
     */
    protected $abstractSkuFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->abstractSkuFilter = new AbstractSkuFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromItems(): void
    {
        $abstractSku = 'FOO-001-001';
        $itemTransferMocks = new ArrayObject([$this->itemTransferMock]);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSku);

        $abstractSkus = $this->abstractSkuFilter->filterFromItems($itemTransferMocks);

        static::assertCount(1, $abstractSkus);
        static::assertContains($abstractSku, $abstractSkus);
    }

    /**
     * @return void
     */
    public function testFilterFromItemsWithInvalidAbstractSku(): void
    {
        $itemTransferMocks = new ArrayObject([$this->itemTransferMock]);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn(null);

        $abstractSkus = $this->abstractSkuFilter->filterFromItems($itemTransferMocks);

        static::assertCount(0, $abstractSkus);
    }
}
