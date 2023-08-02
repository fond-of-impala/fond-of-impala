<?php

namespace FondOfImpala\Client\CompanyUsersRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUsersRestApiStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected $zedRequestClientMock;

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
     * @var \FondOfImpala\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStub
     */
    protected $companyUsersRestApiStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->zedRequestClientMock = $this->getMockBuilder(CompanyUsersRestApiToZedRequestClientInterface::class)
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

        $this->companyUsersRestApiStub = new CompanyUsersRestApiStub(
            $this->zedRequestClientMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/company-users-rest-api/gateway/create',
                $this->restCompanyUsersRequestAttributesTransferMock,
            )
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUsersResponseTransferMock,
            $this->companyUsersRestApiStub->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/company-users-rest-api/gateway/delete-company-user-by-rest-delete-company-user-request',
                $this->restDeleteCompanyUserRequestTransferMock,
            )
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restDeleteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiStub->deleteCompanyUserByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUserByRestWriteCompanyUserRequest(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/company-users-rest-api/gateway/update-company-user-by-rest-write-company-user-request',
                $this->restWriteCompanyUserRequestTransferMock,
            )->willReturn($this->restWriteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restWriteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiStub->updateCompanyUserByRestWriteCompanyUserRequest(
                $this->restWriteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindActiveCompanyUsersByCustomerReference(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/company-users-rest-api/gateway/find-active-company-users-by-customer-reference',
                $this->customerTransferMock,
            )->willReturn($this->companyUserCollectionTransferMock);

        static::assertEquals(
            $this->companyUserCollectionTransferMock,
            $this->companyUsersRestApiStub->findActiveCompanyUsersByCustomerReference(
                $this->customerTransferMock,
            ),
        );
    }
}
