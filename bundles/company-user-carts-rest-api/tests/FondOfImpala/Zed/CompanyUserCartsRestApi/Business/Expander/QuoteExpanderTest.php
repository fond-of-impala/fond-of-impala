<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsRequestAttributesTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpander
     */
    protected $quoteExpander;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyUserCartsRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteExpander = new QuoteExpander($this->configMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $newData = [
            'name' => 'foo bar2',
            'price_mode' => 'NET_MODE',
            'foo' => 'bar',
        ];

        $allowedFieldsToPatchInQuote = ['name'];
        $companyUserReference = 'FOO--CU-1';
        $customerReference = 'FOO--C-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCart')
            ->willReturn($this->restCartsRequestAttributesTransferMock);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getAllowedFieldsToPatchInQuote')
            ->willReturn($allowedFieldsToPatchInQuote);

        $this->restCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn($newData);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setName')
            ->with($newData['name'])
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturnOnConsecutiveCalls(null, $customerReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomerReference')
            ->with($customerReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->with(
                static::callback(
                    static function (CustomerTransfer $customerTransfer) use ($customerReference) {
                        return $customerTransfer->getCustomerReference() === $customerReference;
                    },
                ),
            )->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturnOnConsecutiveCalls(null, $companyUserReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyUser')
            ->with(
                static::callback(
                    static function (CompanyUserTransfer $companyUserTransfer) use ($companyUserReference) {
                        return $companyUserTransfer->getCompanyUserReference() === $companyUserReference;
                    },
                ),
            )->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock),
        );
    }
}
