<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyUserCompanyAssignerToCompanyFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacadeInterfaceMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyFacadeInterfaceMock = $this->getMockBuilder(CompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerToCompanyFacadeBridge = new CompanyUserCompanyAssignerToCompanyFacadeBridge(
            $this->companyFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->with($this->idCompany)
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyUserCompanyAssignerToCompanyFacadeBridge->findCompanyById(
                $this->idCompany,
            ),
        );
    }
}
