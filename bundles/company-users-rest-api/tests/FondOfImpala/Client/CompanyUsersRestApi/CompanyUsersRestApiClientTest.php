<?php

namespace FondOfImpala\Client\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUsersRestApiClientTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface
     */
    protected $companyUsersRestApiStubMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClient
     */
    protected $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUsersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiStubMock = $this->getMockBuilder(CompanyUsersRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserResponseTransferMock = $this->getMockBuilder(RestDeleteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserResponseTransferMock = $this->getMockBuilder(RestWriteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new CompanyUsersRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubMock);

        $this->companyUsersRestApiStubMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUsersResponseTransferMock,
            $this->client->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubMock);

        $this->companyUsersRestApiStubMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restDeleteCompanyUserResponseTransferMock,
            $this->client->deleteCompanyUserByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubMock);

        $this->companyUsersRestApiStubMock->expects(static::atLeastOnce())
            ->method('updateCompanyUserByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->restWriteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restWriteCompanyUserResponseTransferMock,
            $this->client->updateCompanyUserByRestDeleteCompanyUserRequest(
                $this->restWriteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindActiveCompanyUsersByCustomerReference(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubMock);

        $this->companyUsersRestApiStubMock->expects(static::atLeastOnce())
            ->method('findActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        static::assertEquals(
            $this->companyUserCollectionTransferMock,
            $this->client->findActiveCompanyUsersByCustomerReference(
                $this->customerTransferMock,
            ),
        );
    }
}
