<?php

namespace FondOfImpala\Zed\NavisionCompany\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class NavisionCompanyFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyFacade
     */
    protected $navisionCompanyFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyBusinessFactory
     */
    protected $navisionCompanyBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyBusinessFactoryMock = $this->getMockBuilder(NavisionCompanyBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyFacade = new NavisionCompanyFacade();
        $this->navisionCompanyFacade->setFactory($this->navisionCompanyBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyByExternalReference(): void
    {
        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->navisionCompanyFacade->findCompanyByExternalReference($this->companyTransferMock));
    }

    /**
     * @return void
     */
    public function testFindCompanyByDebtorNumber(): void
    {
        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->navisionCompanyFacade->findCompanyByDebtorNumber($this->companyTransferMock));
    }
}
