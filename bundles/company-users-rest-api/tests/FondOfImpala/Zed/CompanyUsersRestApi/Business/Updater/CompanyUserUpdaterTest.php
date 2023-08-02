<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\UpdateCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyUserUpdaterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $currentCompanyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $updatableCompanyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdater
     */
    protected $companyUserUpdater;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionReaderMock = $this->getMockBuilder(CompanyRoleCollectionReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentCompanyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->updatableCompanyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserUpdater = new CompanyUserUpdater(
            $this->companyUserReaderMock,
            $this->companyRoleCollectionReaderMock,
            $this->companyUserFacadeMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateByRestWriteCompanyUserRequest(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(UpdateCompanyUserPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getWriteableByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->updatableCompanyUserTransferMock);

        $this->companyRoleCollectionReaderMock->expects(static::atLeastOnce())
            ->method('getByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->with($this->companyRoleCollectionTransferMock)
            ->willReturn($this->updatableCompanyUserTransferMock);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(1);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturnSelf();

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->updatableCompanyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->updatableCompanyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $restWriteCompanyUserResponseTransfer = $this->companyUserUpdater->updateByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            true,
            $restWriteCompanyUserResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            $this->updatableCompanyUserTransferMock,
            $restWriteCompanyUserResponseTransfer->getCompanyUser(),
        );
    }

    /**
     * @return void
     */
    public function testUpdateByRestWriteCompanyUserRequestWithoutCurrent(): void
    {
        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn(null);

        $this->currentCompanyUserTransferMock->expects(static::never())
            ->method('getIdCompanyUser');

        $this->permissionFacadeMock->expects(static::never())
            ->method('can');

        $this->companyUserReaderMock->expects(static::never())
            ->method('getWriteableByRestWriteCompanyUserRequest');

        $this->companyRoleCollectionReaderMock->expects(static::never())
            ->method('getByRestWriteCompanyUserRequest');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('update');

        $restWriteCompanyUserResponseTransfer = $this->companyUserUpdater->updateByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            false,
            $restWriteCompanyUserResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restWriteCompanyUserResponseTransfer->getCompanyUser(),
        );
    }

    /**
     * @return void
     */
    public function testUpdateByRestWriteCompanyUserRequestWithoutUpdatable(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(UpdateCompanyUserPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getWriteableByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn(null);

        $this->companyRoleCollectionReaderMock->expects(static::never())
            ->method('getByRestWriteCompanyUserRequest');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('update');

        $restWriteCompanyUserResponseTransfer = $this->companyUserUpdater->updateByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            false,
            $restWriteCompanyUserResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restWriteCompanyUserResponseTransfer->getCompanyUser(),
        );
    }

    /**
     * @return void
     */
    public function testUpdateByRestWriteCompanyUserRequestWithError(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(UpdateCompanyUserPermissionPlugin::KEY, $idCompanyUser)
            ->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getWriteableByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->updatableCompanyUserTransferMock);

        $this->companyRoleCollectionReaderMock->expects(static::atLeastOnce())
            ->method('getByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->with($this->companyRoleCollectionTransferMock)
            ->willReturn($this->updatableCompanyUserTransferMock);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(1);

        $this->updatableCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturnSelf();

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->updatableCompanyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $restWriteCompanyUserResponseTransfer = $this->companyUserUpdater->updateByRestWriteCompanyUserRequest(
            $this->restWriteCompanyUserRequestTransferMock,
        );

        static::assertEquals(
            false,
            $restWriteCompanyUserResponseTransfer->getIsSuccess(),
        );

        static::assertEquals(
            null,
            $restWriteCompanyUserResponseTransfer->getCompanyUser(),
        );
    }
}
