<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var int
     */
    protected $idCompanyBusinessUnit;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;
        $this->idCompanyBusinessUnit = 1;

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge = new CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge(
            $this->companyBusinessUnitFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindDefaultBusinessUnitByCompanyId(): void
    {
        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge->findDefaultBusinessUnitByCompanyId(
                $this->idCompany,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyBusinessUnitById(): void
    {
        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyBusinessUnitById')
            ->with($this->idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge->findCompanyBusinessUnitById(
                $this->idCompanyBusinessUnit,
            ),
        );
    }
}
