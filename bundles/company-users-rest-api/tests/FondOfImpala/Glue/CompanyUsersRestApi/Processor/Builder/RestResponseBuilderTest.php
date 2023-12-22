<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilder
     */
    protected $restResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilder = new RestResponseBuilder(
            $this->restResourceBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testBuildCouldNotDeleteCompanyUserRestResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static fn (RestErrorMessageTransfer $restErrorMessageTransfer): bool => $restErrorMessageTransfer->getDetail() === CompanyUsersRestApiConfig::RESPONSE_DETAIL_COULD_NOT_DELETE_COMPANY_USER
                        && $restErrorMessageTransfer->getCode() === CompanyUsersRestApiConfig::RESPONSE_CODE_COULD_NOT_DELETE_COMPANY_USER
                        && $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST,
                ),
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildCouldNotDeleteCompanyUserRestResponse(),
        );
    }

    /**
     * @return void
     */
    public function testBuildCouldNotUpdateCompanyUserRestResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static fn (RestErrorMessageTransfer $restErrorMessageTransfer): bool => $restErrorMessageTransfer->getDetail() === CompanyUsersRestApiConfig::RESPONSE_DETAIL_COULD_NOT_UPDATE_COMPANY_USER
                        && $restErrorMessageTransfer->getCode() === CompanyUsersRestApiConfig::RESPONSE_CODE_COULD_NOT_UPDATE_COMPANY_USER
                        && $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST,
                ),
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildCouldNotUpdateCompanyUserRestResponse(),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyRestResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildEmptyRestResponse(),
        );
    }

    /**
     * @return void
     */
    public function testBuildRestResponse(): void
    {
        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn('company-user-reference');

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->restResponseBuilder->buildRestResponse($this->companyUserTransferMock);

        static::assertInstanceOf(
            RestResponseInterface::class,
            $restResponse,
        );

        static::assertEquals(
            $this->restResponseMock,
            $restResponse,
        );
    }
}
