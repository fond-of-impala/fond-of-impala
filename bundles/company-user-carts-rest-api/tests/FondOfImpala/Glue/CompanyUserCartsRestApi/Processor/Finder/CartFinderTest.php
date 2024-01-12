<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartFinderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestMapperMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResponseBuilderMock;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserCartsRestApiClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUserCartsResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteErrorTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteErrorTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder\CartFinder
     */
    protected $cartFinder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCompanyUserCartsRequestMapperMock = $this->getMockBuilder(RestCompanyUserCartsRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilderMock = $this->getMockBuilder(RestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCartsRestApiClientMock = $this->getMockBuilder(CompanyUserCartsRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsResponseTransferMock = $this->getMockBuilder(RestCompanyUserCartsResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteErrorTransferMock = $this->getMockBuilder(QuoteErrorTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartFinder = new CartFinder(
            $this->restCompanyUserCartsRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->companyUserCartsRestApiClientMock,
        );
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $uuid = '0f6b7d39-5d3a-468b-8808-626a6e98676b';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildCartIdIsMissingRestResponse');

        $this->restCompanyUserCartsRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCompanyUserCartsRequestTransferMock);

        $this->companyUserCartsRestApiClientMock->expects(static::atLeastOnce())
            ->method('findQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::never())
            ->method('getErrors');

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildErrorRestResponse');

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildRestResponse')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->cartFinder->find($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testFindWithoutCartId(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildCartIdIsMissingRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restCompanyUserCartsRequestMapperMock->expects(static::never())
            ->method('fromRestRequest');

        $this->companyUserCartsRestApiClientMock->expects(static::never())
            ->method('findQuoteByRestCompanyUserCartsRequest');

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildErrorRestResponse');

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->cartFinder->find($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testFindWithoutResult(): void
    {
        $uuid = '0f6b7d39-5d3a-468b-8808-626a6e98676b';
        $quoteErrorTransfers = [
            $this->quoteErrorTransferMock,
        ];

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildCartIdIsMissingRestResponse');

        $this->restCompanyUserCartsRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCompanyUserCartsRequestTransferMock);

        $this->companyUserCartsRestApiClientMock->expects(static::atLeastOnce())
            ->method('findQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject($quoteErrorTransfers));

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildErrorRestResponse')
            ->with($quoteErrorTransfers)
            ->willReturn($this->restResponseMock);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->cartFinder->find($this->restRequestMock),
        );
    }
}
