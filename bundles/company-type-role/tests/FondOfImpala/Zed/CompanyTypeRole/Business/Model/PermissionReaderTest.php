<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class PermissionReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Model\PermissionReaderInterface
     */
    protected $permissionReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyTypeRoleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionReader = new PermissionReader($this->configMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeRolePermissionKeys(): void
    {
        $this->configMock->expects($this->atLeastOnce())
            ->method('getPermissionKeys')
            ->with('type', 'role')
            ->willReturn(['permissioKey1, permissionKey2']);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('type');

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('role');

        $permissionKeys = $this->permissionReader
            ->getCompanyTypeRolePermissionKeys($this->companyTypeTransferMock, $this->companyRoleTransferMock);

        $this->assertIsArray($permissionKeys);
        $this->assertNotEmpty($permissionKeys);
    }
}
