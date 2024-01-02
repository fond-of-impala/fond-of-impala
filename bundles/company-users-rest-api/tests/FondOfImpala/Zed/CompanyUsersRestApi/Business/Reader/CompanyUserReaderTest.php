<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReferenceFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUsersRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader(
            $this->companyUserReferenceFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testDoesCompanyUserAlreadyExist(): void
    {
        $fkCompany = 1;
        $fkCustomer = 2;
        $fkCompanyBusinessUnit = 3;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($fkCustomer);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($fkCompany);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn($fkCompanyBusinessUnit);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUsersByFilter')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([]));

        static::assertFalse(
            $this->companyUserReader->doesCompanyUserAlreadyExist(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDoesCompanyUserAlreadyExistNoCompanyUser(): void
    {
        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(null);

        static::assertFalse(
            $this->companyUserReader->doesCompanyUserAlreadyExist(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetCurrentByRestDeleteCompanyUserRequest(): void
    {
        $idCustomer = 1;
        $companyUserReferenceToDelete = 'FOO--CU-1';

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceToDelete')
            ->willReturn($companyUserReferenceToDelete);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByIdCustomerAndForeignCompanyUserReference')
            ->with($idCustomer, $companyUserReferenceToDelete)
            ->willReturn($this->companyUserTransferMock);

        static::assertEquals(
            $this->companyUserTransferMock,
            $this->companyUserReader->getCurrentByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetCurrentByRestDeleteCompanyUserRequestWithInvalidData(): void
    {
        $idCustomer = 1;
        $companyUserReferenceToDelete = null;

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceToDelete')
            ->willReturn($companyUserReferenceToDelete);

        $this->repositoryMock->expects(static::never())
            ->method('findCompanyUserByIdCustomerAndForeignCompanyUserReference');

        static::assertEquals(
            null,
            $this->companyUserReader->getCurrentByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetDeletableByRestDeleteCompanyUserRequest(): void
    {
        $companyUserReferenceToDelete = 'FOO--CU-1';

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceToDelete')
            ->willReturn($companyUserReferenceToDelete);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with(
                static::callback(
                    static fn (CompanyUserTransfer $companyUserTransfer): bool => $companyUserTransfer->getCompanyUserReference() === $companyUserReferenceToDelete,
                ),
            )->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertEquals(
            $this->companyUserTransferMock,
            $this->companyUserReader->getDeletableByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetDeletableByRestDeleteCompanyUserRequestWithInvalidData(): void
    {
        $companyUserReferenceToDelete = null;

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceToDelete')
            ->willReturn($companyUserReferenceToDelete);

        $this->companyUserReferenceFacadeMock->expects(static::never())
            ->method('findCompanyUserByCompanyUserReference');

        static::assertEquals(
            null,
            $this->companyUserReader->getDeletableByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetDeletableByRestDeleteCompanyUserRequestWithoutResult(): void
    {
        $companyUserReferenceToDelete = 'FOO--CU-1';

        $this->restDeleteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceToDelete')
            ->willReturn($companyUserReferenceToDelete);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with(
                static::callback(
                    static fn (CompanyUserTransfer $companyUserTransfer): bool => $companyUserTransfer->getCompanyUserReference() === $companyUserReferenceToDelete,
                ),
            )->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        static::assertEquals(
            null,
            $this->companyUserReader->getDeletableByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetWriteableByRestWriteCompanyUserRequest(): void
    {
        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getWriteableCompanyUserReference')
            ->willReturn('COMPANY-USER-REFERENCE');

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->companyUserReader->getWriteableByRestWriteCompanyUserRequest(
                $this->restWriteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetWriteableByRestWriteCompanyUserRequestWithNullCompanyUserReference(): void
    {
        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
            ->method('getWriteableCompanyUserReference')
            ->willReturn(null);

        $this->companyUserReader->getWriteableByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReference(): void
    {
        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->companyUserReader->getByCompanyUserReference('COMPANY-USER-REFERENCE'),
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReferenceWithNullCompanyUserTransfer(): void
    {
        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserReader->getByCompanyUserReference('COMPANY-USER-REFERENCE');
    }
}
