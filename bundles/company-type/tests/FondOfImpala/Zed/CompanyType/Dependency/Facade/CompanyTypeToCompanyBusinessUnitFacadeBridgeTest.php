<?php

namespace FondOfImpala\Zed\CompanyType\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyTypeToCompanyBusinessUnitFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeBridge
     */
    protected $companyTypeToCompanyBusinessUnitFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeToCompanyBusinessUnitFacadeBridge = new CompanyTypeToCompanyBusinessUnitFacadeBridge(
            $this->companyBusinessUnitFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyBusinessUnitById(): void
    {
        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitById')
            ->with($this->companyBusinessUnitTransferMock)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $companyBusinesssUnitTransfer = $this->companyTypeToCompanyBusinessUnitFacadeBridge
            ->getCompanyBusinessUnitById($this->companyBusinessUnitTransferMock);

        $this->assertEquals($this->companyBusinessUnitTransferMock, $companyBusinesssUnitTransfer);
        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $companyBusinesssUnitTransfer,
        );
    }
}
