<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class NavisionCompanyUserFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUser\Business\NavisionCompanyUserFacade
     */
    protected $navisionCompanyUserFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyUser\Business\NavisionCompanyUserBusinessFactory
     */
    protected $navisionCompanyUserBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyUserBusinessFactoryMock = $this->getMockBuilder(NavisionCompanyUserBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyUserFacade = new NavisionCompanyUserFacade();
        $this->navisionCompanyUserFacade->setFactory($this->navisionCompanyUserBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByUuid(): void
    {
        $this->assertInstanceOf(CompanyUserResponseTransfer::class, $this->navisionCompanyUserFacade->findCompanyUserByUuid($this->companyUserTransferMock));
    }
}
