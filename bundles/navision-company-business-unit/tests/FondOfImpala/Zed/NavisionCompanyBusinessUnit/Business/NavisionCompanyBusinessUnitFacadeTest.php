<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class NavisionCompanyBusinessUnitFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\NavisionCompanyBusinessUnitFacade
     */
    protected $navisionCompanyBusinessUnitFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\NavisionCompanyBusinessUnitBusinessFactory
     */
    protected $navisionCompanyBusinessUnitBusinessFactoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyBusinessUnitBusinessFactoryMock = $this->getMockBuilder(NavisionCompanyBusinessUnitBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyBusinessUnitFacade = new NavisionCompanyBusinessUnitFacade();
        $this->navisionCompanyBusinessUnitFacade->setFactory($this->navisionCompanyBusinessUnitBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyBusinessUnitByExternalReference(): void
    {
        $this->assertInstanceOf(CompanyBusinessUnitResponseTransfer::class, $this->navisionCompanyBusinessUnitFacade->findCompanyBusinessUnitByExternalReference($this->companyBusinessUnitTransferMock));
    }
}
