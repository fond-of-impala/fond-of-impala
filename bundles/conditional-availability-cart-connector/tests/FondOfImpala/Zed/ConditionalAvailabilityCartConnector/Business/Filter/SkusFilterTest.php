<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SkusFilterTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\ItemTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilter
     */
    protected SkusFilter $skusFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->skusFilter = new SkusFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromQuote(): void
    {
        $sku = 'FOO-1';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(
                new ArrayObject(
                    [
                        $this->itemTransferMock,
                    ],
                ),
            );

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        static::assertEquals(
            [$sku],
            $this->skusFilter->filterFromQuote($this->quoteTransferMock),
        );
    }
}
