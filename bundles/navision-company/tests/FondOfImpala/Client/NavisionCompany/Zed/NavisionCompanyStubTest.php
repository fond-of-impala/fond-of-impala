<?php

namespace FondOfImpala\Client\NavisionCompany\Dependency\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface;
use FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStub;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class NavisionCompanyStubTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\NavisionCompany\Zed\NavisionCompanyStub
     */
    protected $navisionCompanyStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(NavisionCompanyToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->navisionCompanyStub = new NavisionCompanyStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyByExternalReference(): void
    {
        $this->zedRequestClientMock->expects($this->atLeastOnce())
            ->method('call')
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->navisionCompanyStub->findCompanyByExternalReference($this->companyTransferMock));
    }
}
