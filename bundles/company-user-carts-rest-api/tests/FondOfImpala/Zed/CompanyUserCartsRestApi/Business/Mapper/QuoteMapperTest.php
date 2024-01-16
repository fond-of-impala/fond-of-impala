<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsRequestAttributesTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapper
     */
    protected $quoteMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteMapper = new QuoteMapper();
    }

    /**
     * @return void
     */
    public function testFromRestCompanyUserCartsRequest(): void
    {
        $data = [];
        $currency = 'EUR';
        $store = 'FOO';
        $idCustomer = 1;
        $customerReference = 'FOO--C-1';
        $companyUserReference = 'FOO--CU-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn($this->restCartsRequestAttributesTransferMock);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($currency);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getStore')
            ->willReturn($store);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $quoteTransfer = $this->quoteMapper->fromRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertEquals($currency, $quoteTransfer->getCurrency()->getCode());
        static::assertEquals($store, $quoteTransfer->getStore()->getName());
        static::assertEquals($customerReference, $quoteTransfer->getCustomerReference());
        static::assertEquals($customerReference, $quoteTransfer->getCustomer()->getCustomerReference());
        static::assertEquals($idCustomer, $quoteTransfer->getCustomer()->getIdCustomer());
        static::assertEquals($companyUserReference, $quoteTransfer->getCompanyUserReference());
        static::assertEquals($companyUserReference, $quoteTransfer->getCompanyUser()->getCompanyUserReference());
    }

    /**
     * @return void
     */
    public function testFromRestCartsRequestAttributes(): void
    {
        $data = [];
        $currency = 'EUR';
        $store = 'FOO';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn($this->restCartsRequestAttributesTransferMock);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($currency);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getStore')
            ->willReturn($store);

        $quoteTransfer = $this->quoteMapper->fromRestCompanyUserCartsRequest(
            $this->restCompanyUserCartsRequestTransferMock,
        );

        static::assertEquals($currency, $quoteTransfer->getCurrency()->getCode());
        static::assertEquals($store, $quoteTransfer->getStore()->getName());
    }
}
