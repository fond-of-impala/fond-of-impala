<?php

namespace FondOfImpala\Client\NavisionCompany\Dependency;

use Codeception\Test\Unit;
use FondOfImpala\Client\NavisionCompany\NavisionCompanyClient;
use FondOfImpala\Client\NavisionCompany\NavisionCompanyFactory;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class NavisionCompanyClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\NavisionCompany\NavisionCompanyClient
     */
    protected $navisionCompanyClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\NavisionCompany\NavisionCompanyFactory
     */
    protected $navisionCompanyFactoryMock;

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

        $this->navisionCompanyFactoryMock = $this->getMockBuilder(NavisionCompanyFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyClient = new NavisionCompanyClient();
        $this->navisionCompanyClient->setFactory($this->navisionCompanyFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyByExternalReference(): void
    {
        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->navisionCompanyClient->findCompanyByExternalReference($this->companyTransferMock));
    }
}
