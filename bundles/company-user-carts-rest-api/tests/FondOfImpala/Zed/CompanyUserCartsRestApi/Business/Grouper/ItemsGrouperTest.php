<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ItemsGrouperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var array<(\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject)>
     */
    protected $itemTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouper
     */
    protected $itemsGrouper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->itemsGrouper = new ItemsGrouper();
    }

    /**
     * @return void
     */
    public function testGroupByQuote(): void
    {
        $groupKeys = [
            'foo.bar-1',
            'foo.bar-2',
            'bar.bar-2',
        ];

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject($this->itemTransferMocks));

        foreach ($this->itemTransferMocks as $index => $itemTransferMock) {
            $itemTransferMock->expects(static::atLeastOnce())
                ->method('getGroupKey')
                ->willReturn($groupKeys[$index]);
        }

        $groupedItemTransfers = $this->itemsGrouper->groupByQuote($this->quoteTransferMock);

        static::assertEquals(
            $groupKeys,
            array_keys($groupedItemTransfers),
        );
    }
}
