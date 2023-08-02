<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestMapperMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResponseBuilderMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleter
     */
    protected $companyUserDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restDeleteCompanyUserRequestMapperMock = $this->getMockBuilder(RestDeleteCompanyUserRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilderMock = $this->getMockBuilder(RestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserResponseTransferMock = $this->getMockBuilder(RestDeleteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = new CompanyUserDeleter(
            $this->restDeleteCompanyUserRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->restDeleteCompanyUserRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restDeleteCompanyUserRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        $this->restDeleteCompanyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildCouldNotDeleteCompanyUserRestResponse');

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildEmptyRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUserDeleter->delete($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteWithError(): void
    {
        $this->restDeleteCompanyUserRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restDeleteCompanyUserRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        $this->restDeleteCompanyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(false);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildCouldNotDeleteCompanyUserRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseBuilderMock->expects(static::never())
            ->method('buildEmptyRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUserDeleter->delete($this->restRequestMock),
        );
    }
}
