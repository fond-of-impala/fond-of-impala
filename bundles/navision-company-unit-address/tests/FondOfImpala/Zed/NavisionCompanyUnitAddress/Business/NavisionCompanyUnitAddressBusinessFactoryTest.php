<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader\CompanyUnitAddressReaderInterface;
use FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepository;

class NavisionCompanyUnitAddressBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\NavisionCompanyUnitAddressBusinessFactory
     */
    protected $navisionCompanyUnitAddressBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepository
     */
    protected $navisionCompanyUnitAddressRepositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyUnitAddressRepositoryMock = $this->getMockBuilder(NavisionCompanyUnitAddressRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyUnitAddressBusinessFactory = new NavisionCompanyUnitAddressBusinessFactory();
        $this->navisionCompanyUnitAddressBusinessFactory->setRepository($this->navisionCompanyUnitAddressRepositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUnitAddressReader(): void
    {
        $this->assertInstanceOf(CompanyUnitAddressReaderInterface::class, $this->navisionCompanyUnitAddressBusinessFactory->createCompanyUnitAddressReader());
    }
}
