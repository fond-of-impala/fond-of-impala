<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClientInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartDeleterTest extends Unit
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
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter\CartDeleter
     */
    protected $cartDeleter;

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

        $this->cartDeleter = new CartDeleter(
            $this->restCompanyUserCartsRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->companyUserCartsRestApiClientMock,
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->restCompanyUserCartsRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCompanyUserCartsRequestTransferMock);

        $this->companyUserCartsRestApiClientMock->expects(static::atLeastOnce())
            ->method('deleteQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::never())
            ->method('getErrors');

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildErrorRestResponse');

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildEmptyRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->cartDeleter->delete($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteWithError(): void
    {
        $quoteErrorTransferMocks = [
            $this->quoteErrorTransferMock,
        ];

        $this->restCompanyUserCartsRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCompanyUserCartsRequestTransferMock);

        $this->companyUserCartsRestApiClientMock->expects(static::atLeastOnce())
            ->method('deleteQuoteByRestCompanyUserCartsRequest')
            ->with($this->restCompanyUserCartsRequestTransferMock)
            ->willReturn($this->restCompanyUserCartsResponseTransferMock);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->restCompanyUserCartsResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject($quoteErrorTransferMocks));

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildErrorRestResponse')
            ->with($quoteErrorTransferMocks)
            ->willReturn($this->restResponseMock);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildEmptyRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->cartDeleter->delete($this->restRequestMock),
        );
    }
}
