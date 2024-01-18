<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TaxTotalTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

class CartMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\DiscountTransfer>
     */
    protected $voucherDiscountMocks;

    /**
     * @var array<\Generated\Shared\Transfer\DiscountTransfer>
     */
    protected $cartRuleDiscountsMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\TotalsTransfer
     */
    protected $totalsTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\TaxTotalTransfer
     */
    protected $taxTotalTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapper
     */
    protected $cartMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->voucherDiscountMocks = new ArrayObject([
            $this->getMockBuilder(DiscountTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ]);

        $this->cartRuleDiscountsMocks = new ArrayObject([
              $this->getMockBuilder(DiscountTransfer::class)
                  ->disableOriginalConstructor()
                  ->getMock(),
        ]);

        $this->totalsTransferMock = $this->getMockBuilder(TotalsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->taxTotalTransferMock = $this->getMockBuilder(TaxTotalTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartMapper = new CartMapper();
    }

    /**
     * @return void
     */
    public function testMapQuoteTransferToRestCartsAttributesTransfer(): void
    {
        $currencyCode = 'EUR';
        $storeName = 'STORE';
        $taxTotalAmount = 109;

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(self::atLeastOnce())
            ->method('getCode')
            ->willReturn($currencyCode);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(self::atLeastOnce())
            ->method('getName')
            ->willReturn($storeName);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getTotals')
            ->willReturn($this->totalsTransferMock);

        $this->totalsTransferMock->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->totalsTransferMock->expects(self::atLeastOnce())
            ->method('getTaxTotal')
            ->willReturn($this->taxTotalTransferMock);

        $this->taxTotalTransferMock->expects(self::atLeastOnce())
            ->method('getAmount')
            ->willReturn($taxTotalAmount);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getVoucherDiscounts')
            ->willReturn($this->voucherDiscountMocks);

        $this->voucherDiscountMocks->offsetGet(0)->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCartRuleDiscounts')
            ->willReturn($this->cartRuleDiscountsMocks);

        $this->cartRuleDiscountsMocks->offsetGet(0)->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $restCartsAttributesTransfer = $this->cartMapper->mapQuoteTransferToRestCartsAttributesTransfer(
            $this->quoteTransferMock,
        );

        self::assertEquals($storeName, $restCartsAttributesTransfer->getStore());
        self::assertEquals($currencyCode, $restCartsAttributesTransfer->getCurrency());
        self::assertEquals($taxTotalAmount, $restCartsAttributesTransfer->getTotals()->getTaxTotal());
    }

    /**
     * @return void
     */
    public function testMapQuoteTransferToRestCartsAttributesTransferWithoutTotals(): void
    {
        $currencyCode = 'EUR';
        $storeName = 'STORE';

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(self::atLeastOnce())
            ->method('getCode')
            ->willReturn($currencyCode);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(self::atLeastOnce())
            ->method('getName')
            ->willReturn($storeName);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getTotals')
            ->willReturn(null);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getVoucherDiscounts')
            ->willReturn($this->voucherDiscountMocks);

        $this->voucherDiscountMocks->offsetGet(0)->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getCartRuleDiscounts')
            ->willReturn($this->cartRuleDiscountsMocks);

        $this->cartRuleDiscountsMocks->offsetGet(0)->expects(self::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $restCartsAttributesTransfer = $this->cartMapper->mapQuoteTransferToRestCartsAttributesTransfer(
            $this->quoteTransferMock,
        );

        self::assertEquals($storeName, $restCartsAttributesTransfer->getStore());
        self::assertEquals($currencyCode, $restCartsAttributesTransfer->getCurrency());
        self::assertEquals(null, $restCartsAttributesTransfer->getTotals()->getTaxTotal());
    }
}
