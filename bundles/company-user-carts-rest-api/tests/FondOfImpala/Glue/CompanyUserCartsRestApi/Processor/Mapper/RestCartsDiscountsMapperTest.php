<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class RestCartsDiscountsMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\DiscountTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $discountTransferMocks;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapper
     */
    protected $restCartsDiscountsMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountTransferMocks = [
            $this->getMockBuilder(DiscountTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(DiscountTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restCartsDiscountsMapper = new RestCartsDiscountsMapper();
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getVoucherDiscounts')
            ->willReturn(new ArrayObject([$this->discountTransferMocks[0]]));

        $this->discountTransferMocks[0]->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCartRuleDiscounts')
            ->willReturn(new ArrayObject([$this->discountTransferMocks[1]]));

        $this->discountTransferMocks[1]->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertCount(2, $this->restCartsDiscountsMapper->fromQuote($this->quoteTransferMock));
    }
}
