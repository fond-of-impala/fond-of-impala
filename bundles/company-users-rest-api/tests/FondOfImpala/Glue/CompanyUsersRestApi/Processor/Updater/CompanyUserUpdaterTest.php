<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserUpdaterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    protected $restWriteCompanyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restWriteCompanyUserRequestMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilder
     */
    protected $restResponseBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdater
     */
    protected $companyUserUpdater;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this
            ->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserResponseTransferMock = $this->getMockBuilder(RestWriteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestMapperMock = $this->getMockBuilder(RestWriteCompanyUserRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilderMock = $this->getMockBuilder(RestResponseBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserUpdater = new CompanyUserUpdater(
            $this->restWriteCompanyUserRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->restWriteCompanyUserRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restWriteCompanyUserRequestTransferMock);

        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('setRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restWriteCompanyUserRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('updateCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->restWriteCompanyUserResponseTransferMock);

        $this->restWriteCompanyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restWriteCompanyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUserUpdater->update(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithMissingCompanyUserTransfer(): void
    {
        $this->restWriteCompanyUserRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restWriteCompanyUserRequestTransferMock);

        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('setRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restWriteCompanyUserRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('updateCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->restWriteCompanyUserResponseTransferMock);

        $this->restWriteCompanyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildCouldNotUpdateCompanyUserRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUserUpdater->update(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }
}
