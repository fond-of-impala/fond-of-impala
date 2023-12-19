<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyUserCompanyAssignerToCompanyRoleFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyRoleFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyRoleFacadeInterfaceMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerToCompanyRoleFacadeBridge = new CompanyUserCompanyAssignerToCompanyRoleFacadeBridge(
            $this->companyRoleFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyRoleById(): void
    {
        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleTransferMock);

        $this->assertInstanceOf(
            CompanyRoleTransfer::class,
            $this->companyUserCompanyAssignerToCompanyRoleFacadeBridge->getCompanyRoleById(
                $this->companyRoleTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testSaveCompanyUser(): void
    {
        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('saveCompanyUser')
            ->with($this->companyUserTransferMock);

        $this->companyUserCompanyAssignerToCompanyRoleFacadeBridge->saveCompanyUser($this->companyUserTransferMock);
    }
}
