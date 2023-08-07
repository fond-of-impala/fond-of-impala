<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\DeleteCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserPluginExecutorInterface|MockObject $pluginExecutorMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleter
     */
    protected $companyUserDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pluginExecutorMock = $this->getMockBuilder(CompanyUserPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = new CompanyUserDeleter(
            $this->companyUserReaderMock,
            $this->companyUserFacadeMock,
            $this->permissionFacadeMock,
            $this->pluginExecutorMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequest(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                DeleteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->pluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreDeleteValidationPlugins')
            ->willReturn(true);

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertTrue($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithoutRequiredPermission(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                DeleteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(false);

        $this->companyUserReaderMock->expects(static::never())
            ->method('getDeletableByRestDeleteCompanyUserRequest');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('deleteCompanyUser');

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithoutDeletableCompanyUser(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                DeleteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn(null);

        $this->companyUserFacadeMock->expects(static::never())
            ->method('deleteCompanyUser');

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithDeletionError(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                DeleteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->pluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreDeleteValidationPlugins')
            ->willReturn(true);

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }
}
