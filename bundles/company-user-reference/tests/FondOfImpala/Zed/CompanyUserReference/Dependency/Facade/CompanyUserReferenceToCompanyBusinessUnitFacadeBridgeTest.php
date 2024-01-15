<?php

namespace FondOfImpala\Zed\CompanyUserReference\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyUserReferenceToCompanyBusinessUnitFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserReferenceToCompanyBusinessUnitFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $idCompanyBusinessUnit = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findCompanyBusinessUnitById')
            ->with($idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $this->bridge->findCompanyBusinessUnitById($idCompanyBusinessUnit),
        );
    }
}
