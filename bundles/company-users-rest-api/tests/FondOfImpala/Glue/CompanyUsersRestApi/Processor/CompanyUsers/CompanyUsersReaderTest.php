<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReader;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface|mixed
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $clientMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserReferenceClientMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUsersMapperMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restApiErrorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface|mixed
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface|mixed
     */
    protected $restResponseMock;

    /**
     * @var \Generated\Shared\Transfer\RestUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface|mixed
     */
    protected $restResourceMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserTransferMock;

    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject>|array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    protected $companyUserTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReader
     */
    protected $companyUsersReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceClientMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersMapperMock = $this->getMockBuilder(CompanyUsersMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMocks = [$this->companyUserTransferMock];

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersReader = new CompanyUserReader(
            $this->restResourceBuilderMock,
            $this->clientMock,
            $this->companyUserReferenceClientMock,
            $this->companyUsersMapperMock,
            $this->restApiErrorMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCurrentCompanyUsers(): void
    {
        $customerReference = 'STORE--C-1';

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($customerReference);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('findActiveCompanyUsersByCustomerReference')
            ->with(
                static::callback(
                    static fn (CustomerTransfer $customerTransfer): bool => $customerTransfer->getCustomerReference() === $customerReference,
                ),
            )->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUserTransferMocks);

        $this->companyUsersMapperMock->expects(static::atLeastOnce())
            ->method('mapCompanyUsersResource')
            ->with($this->companyUserTransferMocks[0])
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->willReturn($this->restResourceMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUsersReader->findCurrentCompanyUsers(
                $this->restRequestMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindCurrentCompanyUsersAccessDeniedError(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn(null);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addAccessDeniedError')
            ->with($this->restResponseMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->companyUsersReader->findCurrentCompanyUsers(
                $this->restRequestMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUser(): void
    {
        $restUserId = '1';
        $companyUserReference = 'company-user-reference';

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($restUserId);

        $this->companyUserReferenceClientMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(1);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn(1);

        $this->companyUsersMapperMock->expects(static::atLeastOnce())
            ->method('mapCompanyUsersResource')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->willReturn($this->restResponseMock);

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersReader->findCompanyUser(
                $this->restRequestMock,
            ),
        );
    }
}
