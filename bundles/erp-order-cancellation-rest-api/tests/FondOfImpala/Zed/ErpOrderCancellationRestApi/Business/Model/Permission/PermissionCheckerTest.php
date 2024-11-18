<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PermissionCheckerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface
     */
    protected MockObject|ErpOrderCancellationPermissionPluginInterface $permissionPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface
     */
    protected MockObject|ErpOrderCancellationPermissionPluginInterface $permissionPluginMock2;

    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface>
     */
    protected array $pluginMocks = [];

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionChecker
     */
    protected PermissionChecker $permissionChecker;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restErpOrderCancellationRequestTransferMock = $this->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionPluginMock = $this->getMockBuilder(ErpOrderCancellationPermissionPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionPluginMock2 = $this->getMockBuilder(ErpOrderCancellationPermissionPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $plugins = [
            $this->permissionPluginMock,
            $this->permissionPluginMock2,
        ];

        $this->permissionChecker = new PermissionChecker($plugins);
    }

    /**
     * @return void
     */
    public function testCheckPermission(): void
    {
        $this->permissionPluginMock->expects(static::atLeastOnce())
            ->method('isApplicable')
            ->willReturn(false);

        $this->permissionPluginMock2->expects(static::atLeastOnce())
            ->method('isApplicable')
            ->willReturn(true);

        $this->permissionPluginMock->expects(static::never())
            ->method('can');

        $this->permissionPluginMock2->expects(static::atLeastOnce())
            ->method('can')
            ->willReturn(true);

        $this->permissionChecker->checkPermission($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock, 'type');
    }

    /**
     * @return void
     */
    public function testCheckPermissionDenied(): void
    {
        $this->permissionPluginMock->expects(static::atLeastOnce())
            ->method('isApplicable')
            ->willReturn(true);

        $this->permissionPluginMock2->expects(static::never())
            ->method('isApplicable');

        $this->permissionPluginMock->expects(static::atLeastOnce())
            ->method('can')
            ->willReturn(false);

        $this->permissionPluginMock2->expects(static::never())
            ->method('can');

        $this->permissionChecker->checkPermission($this->erpOrderCancellationTransferMock, $this->companyUserTransferMock, 'type');
    }
}
