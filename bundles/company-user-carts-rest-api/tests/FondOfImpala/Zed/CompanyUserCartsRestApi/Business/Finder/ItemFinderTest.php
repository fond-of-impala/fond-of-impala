<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;

class ItemFinderTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestCartItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartItemTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $itemTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinder
     */
    protected $itemFinder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            'foo.bar-1' => $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->itemFinder = new ItemFinder();
    }

    /**
     * @return void
     */
    public function testFindInGroupedItemsByRestCartItem(): void
    {
        $key = array_keys($this->itemTransferMocks)[0];

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($key);

        static::assertEquals(
            $this->itemTransferMocks[$key],
            $this->itemFinder->findInGroupedItemsByRestCartItem(
                $this->itemTransferMocks,
                $this->restCartItemTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindInQuoteByRestCartItemWithoutResult(): void
    {
        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn('foo.bar-3');

        static::assertEquals(
            null,
            $this->itemFinder->findInGroupedItemsByRestCartItem(
                $this->itemTransferMocks,
                $this->restCartItemTransferMock,
            ),
        );
    }
}
