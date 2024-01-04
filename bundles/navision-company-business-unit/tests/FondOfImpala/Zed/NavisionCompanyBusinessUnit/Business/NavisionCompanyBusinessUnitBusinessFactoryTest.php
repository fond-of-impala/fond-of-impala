<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader\CompanyBusinessUnitReaderInterface;
use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepository;

class NavisionCompanyBusinessUnitBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\NavisionCompanyBusinessUnitBusinessFactory
     */
    protected $navisionCompanyBusinessUnitBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepository
     */
    protected $navisionCompanyBusinessUnitRepository;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyBusinessUnitRepository = $this->getMockBuilder(NavisionCompanyBusinessUnitRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyBusinessUnitBusinessFactory = new NavisionCompanyBusinessUnitBusinessFactory();
        $this->navisionCompanyBusinessUnitBusinessFactory->setRepository($this->navisionCompanyBusinessUnitRepository);
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitReader(): void
    {
        $this->assertInstanceOf(CompanyBusinessUnitReaderInterface::class, $this->navisionCompanyBusinessUnitBusinessFactory->createCompanyBusinessUnitReader());
    }
}
