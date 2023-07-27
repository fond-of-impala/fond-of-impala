<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersBulkProcessorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer
     */
    protected $restAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface
     */
    protected $mapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $responseBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer
     */
    protected $processorResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer
     */
    protected $mapperResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface
     */
    protected $clientMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessor
     */
    protected $processor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseBuilderMock = $this->getMockBuilder(RestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersBulkRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapperMock = $this->getMockBuilder(RestCompanyUsersBulkRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->processorResponseMock = $this->getMockBuilder(RestCompanyUsersBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapperResponseMock = $this->getMockBuilder(RestCompanyUsersBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->processor = new CompanyUsersBulkProcessor(
            $this->mapperMock,
            $this->clientMock,
            $this->responseBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $this->mapperMock->expects(static::atLeastOnce())
            ->method('createRequest')
            ->willReturn($this->mapperResponseMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->mapperResponseMock)
            ->willReturn($this->processorResponseMock);

        $this->processorResponseMock->expects(static::atLeastOnce())
            ->method('getError')
            ->willReturn(null);

        $this->responseBuilderMock->expects(static::atLeastOnce())
            ->method('buildEmptyRestResponse')
            ->willReturn($this->restResponseMock);

        $this->processor->process($this->restRequestMock, $this->restAttributesTransferMock);
    }
}
