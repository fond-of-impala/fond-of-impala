<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellationRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Shared\ErpOrderCancellationRestApiExtension\ErpOrderCancellationRestApiExtensionConstants;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\ErpOrderCancellationManagePermissionPlugin;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepository;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationDeletePermissionPluginTest extends Unit
{
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    protected ErpOrderCancellationTransfer|MockObject $erpOrderCancellationTransferMock;

    protected PermissionErpOrderCancellationRestApiRepositoryInterface|MockObject $repositoryMock;

    protected ErpOrderCancellationDeletePermissionPlugin $plugin;

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

        $this->plugin = new ErpOrderCancellationDeletePermissionPlugin();
        $this->plugin->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->assertTrue($this->plugin->isApplicable($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock, ErpOrderCancellationRestApiExtensionConstants::PERMISSION_TYPE_DELETE));
    }

    /**
     * @return void
     */
    public function testCanDelete(): void
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
    public function testCanNotDelete(): void
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

                return false;
            });

        $this->assertFalse($this->plugin->can($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock));
    }
}
