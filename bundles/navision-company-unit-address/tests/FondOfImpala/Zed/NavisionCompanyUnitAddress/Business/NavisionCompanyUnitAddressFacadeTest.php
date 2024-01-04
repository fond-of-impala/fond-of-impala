<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUnitAddressResponseTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;

class NavisionCompanyUnitAddressFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\NavisionCompanyUnitAddressFacade
     */
    protected $navisionCompanyUnitAddressFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\NavisionCompanyUnitAddressBusinessFactory
     */
    protected $navisionCompanyUnitAddressBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected $companyUnitAddressTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyUnitAddressBusinessFactoryMock = $this->getMockBuilder(NavisionCompanyUnitAddressBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddressTransferMock = $this->getMockBuilder(CompanyUnitAddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyUnitAddressFacade = new NavisionCompanyUnitAddressFacade();
        $this->navisionCompanyUnitAddressFacade->setFactory($this->navisionCompanyUnitAddressBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyUnitAddressByExternalReference(): void
    {
        $this->assertInstanceOf(CompanyUnitAddressResponseTransfer::class, $this->navisionCompanyUnitAddressFacade->findCompanyUnitAddressByExternalReference($this->companyUnitAddressTransferMock));
    }
}
