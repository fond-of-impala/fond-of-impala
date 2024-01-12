<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReader
     */
    protected $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteFacadeMock = $this->getMockBuilder(CompanyUserCartsRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteResponseTransferMock = $this->getMockBuilder(QuoteResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReader = new QuoteReader($this->quoteFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequest(): void
    {
        $uuid = '63c24f88-cd4d-429f-ae3b-21c919776166';
        $companyUserReference = 'FOO--CU-1';
        $customerReference = 'FOO--C-1';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCart')
            ->willReturn($uuid);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteByUuid')
            ->with(
                static::callback(
                    static function (QuoteTransfer $quoteTransfer) use ($uuid) {
                        return $quoteTransfer->getUuid() === $uuid;
                    },
                ),
            )->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequestWithNullableUuid(): void
    {
        $uuid = null;

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCart')
            ->willReturn($uuid);

        $this->quoteFacadeMock->expects(static::never())
            ->method('findQuoteByUuid');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('getCustomerReference');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('getCompanyUserReference');

        static::assertEquals(
            null,
            $this->quoteReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCompanyUserCartsRequestWithoutResult(): void
    {
        $uuid = '63c24f88-cd4d-429f-ae3b-21c919776166';

        $this->restCompanyUserCartsRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCart')
            ->willReturn($uuid);

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteByUuid')
            ->with(
                static::callback(
                    static function (QuoteTransfer $quoteTransfer) use ($uuid) {
                        return $quoteTransfer->getUuid() === $uuid;
                    },
                ),
            )->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('getCustomerReference');

        $this->restCompanyUserCartsRequestTransferMock->expects(static::never())
            ->method('getCompanyUserReference');

        static::assertEquals(
            null,
            $this->quoteReader->getByRestCompanyUserCartsRequest($this->restCompanyUserCartsRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByIdQuote(): void
    {
        $idQuote = 1;

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn($this->quoteTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteReader->getByIdQuote($idQuote),
        );
    }

    /**
     * @return void
     */
    public function testGetByIdQuoteWithError(): void
    {
        $idQuote = 1;

        $this->quoteFacadeMock->expects(static::atLeastOnce())
            ->method('findQuoteById')
            ->with($idQuote)
            ->willReturn($this->quoteResponseTransferMock);

        $this->quoteResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuoteTransfer')
            ->willReturn(null);

        $this->quoteResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        static::assertEquals(
            null,
            $this->quoteReader->getByIdQuote($idQuote),
        );
    }
}
