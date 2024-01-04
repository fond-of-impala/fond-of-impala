<?php

namespace FondOfImpala\Zed\NavisionCompany\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompany\Business\Reader\CompanyReaderInterface;
use FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepository;

class NavisionCompanyBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyBusinessFactory
     */
    protected $navisionCompanyBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepository
     */
    protected $navisionCompanyRepositoryInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyRepositoryInterfaceMock = $this->getMockBuilder(NavisionCompanyRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyBusinessFactory = new NavisionCompanyBusinessFactory();
        $this->navisionCompanyBusinessFactory->setRepository($this->navisionCompanyRepositoryInterfaceMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyReader(): void
    {
        $this->assertInstanceOf(CompanyReaderInterface::class, $this->navisionCompanyBusinessFactory->createCompanyReader());
    }
}
