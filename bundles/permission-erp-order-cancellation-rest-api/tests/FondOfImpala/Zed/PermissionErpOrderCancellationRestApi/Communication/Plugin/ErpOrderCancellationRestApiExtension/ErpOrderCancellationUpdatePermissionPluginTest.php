<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellationRestApiExtension;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Shared\ErpOrderCancellationRestApiExtension\ErpOrderCancellationRestApiExtensionConstants;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationCreatePermissionPlugin as PermissionErpOrderCancellationCreatePermissionPlugin;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationManagePermissionPlugin;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepository;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationUpdatePermissionPluginTest extends Unit
{
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    protected ErpOrderCancellationTransfer|MockObject $erpOrderCancellationTransferMock;

    protected PermissionErpOrderCancellationRestApiRepositoryInterface|MockObject $repositoryMock;

    protected ErpOrderCancellationUpdatePermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(PermissionErpOrderCancellationRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErpOrderCancellationUpdatePermissionPlugin();
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->assertTrue($this->plugin->isApplicable($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock, ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_UPDATE));
    }

    /**
     * @return void
     */
    public function testCanUpdate(): void
    {
        $self = $this;
        $this->companyUserTransferMock->expects(static::once())
            ->method('getIdCompanyUser')
            ->willReturn(1);

        $this->repositoryMock->expects(static::once())
            ->method('hasPermission')
            ->willReturnCallback(static function (int $id, string $permissionKey) use ($self) {
                $self->assertSame(1, $id);
                $self->assertSame(ErpOrderCancellationManagePermissionPlugin::KEY, $permissionKey);

                return true;
            });

        $this->assertTrue($this->plugin->can($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock));
    }

    /**
     * @return void
     */
    public function testCanWithReducedPermissions(): void
    {
        $self = $this;
        $this->companyUserTransferMock->expects(static::exactly(2))
            ->method('getIdCompanyUser')
            ->willReturn(1);

        $callCount = static::exactly(2);
        $this->repositoryMock->expects($callCount)
            ->method('hasPermission')
            ->willReturnCallback(static function (int $id, string $permissionKey) use ($self, $callCount) {
                if (method_exists($callCount, 'getInvocationCount')) {
                    $count = $callCount->getInvocationCount();
                } else {
                    $count = $callCount->numberOfInvocations();
                }

                $self->assertSame(1, $id);
                switch ($count) {
                    case 1:
                        $self->assertSame(ErpOrderCancellationManagePermissionPlugin::KEY, $permissionKey);

                        return false;
                    case 2:
                        $self->assertSame(PermissionErpOrderCancellationCreatePermissionPlugin::KEY, $permissionKey);

                        return true;
                }

                throw new Exception('Unexpected call count');
            });

        $this->erpOrderCancellationTransferMock->expects(static::once())
            ->method('getState')
            ->willReturn('new');

        $this->assertTrue($this->plugin->can($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock));
    }

    /**
     * @return void
     */
    public function testCanNotUpdate(): void
    {
        $self = $this;
        $this->companyUserTransferMock->expects(static::exactly(2))
            ->method('getIdCompanyUser')
            ->willReturn(1);

        $callCount = static::exactly(2);
        $this->repositoryMock->expects($callCount)
            ->method('hasPermission')
            ->willReturnCallback(static function (int $id, string $permissionKey) use ($self, $callCount) {
                if (method_exists($callCount, 'getInvocationCount')) {
                    $count = $callCount->getInvocationCount();
                } else {
                    $count = $callCount->numberOfInvocations();
                }

                $self->assertSame(1, $id);
                switch ($count) {
                    case 1:
                        $self->assertSame(ErpOrderCancellationManagePermissionPlugin::KEY, $permissionKey);

                        return false;
                    case 2:
                        $self->assertSame(PermissionErpOrderCancellationCreatePermissionPlugin::KEY, $permissionKey);

                        return false;
                }

                throw new Exception('Unexpected call count');
            });

        $this->assertFalse($this->plugin->can($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock));
    }
}
