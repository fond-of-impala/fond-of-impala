<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreator;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiErrorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer
     */
    protected $restCompanyUsersResponseAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreator
     */
    protected $companyUsersWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilder = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersWriter = new CompanyUserCreator(
            $this->restResourceBuilder,
            $this->clientMock,
            $this->restApiErrorMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserAccessDeniedError(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn(null);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addAccessDeniedError')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUsersWriter->create(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUser(): void
    {
        $idCustomer = 1;
        $restUserMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($restUserMock);

        $restUserMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($idCustomer);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('setCurrentCustomer')
            ->willReturn($this->restCompanyUsersRequestAttributesTransferMock);

        $this->clientMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        $this->restCompanyUsersResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restCompanyUsersResponseTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersResponseAttributes')
            ->willReturn($this->restCompanyUsersResponseAttributesTransferMock);

        $this->restResourceBuilder->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->willReturn($this->restResourceMock);

        $this->restResourceBuilder->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUsersWriter->create(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }
}
