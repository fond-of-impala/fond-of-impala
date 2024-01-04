<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyBusinessUnitReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader\CompanyBusinessUnitReader
     */
    protected $companyBusinessUnitReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface
     */
    protected $navisionCompanyBusinessUnitRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyBusinessUnitRepositoryMock = $this->getMockBuilder(NavisionCompanyBusinessUnitRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitReader = new CompanyBusinessUnitReader($this->navisionCompanyBusinessUnitRepositoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyBusinessUnitByExternalReference(): void
    {
        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('string');

        $this->navisionCompanyBusinessUnitRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyBusinessUnitByExternalReference')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->assertInstanceOf(CompanyBusinessUnitResponseTransfer::class, $this->companyBusinessUnitReader->findCompanyBusinessUnitByExternalReference($this->companyBusinessUnitTransferMock));
    }
}
