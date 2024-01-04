<?php

namespace FondOfImpala\Zed\NavisionCompany\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompany\Business\Reader\CompanyReader
     */
    protected $companyReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface
     */
    protected $navisionCompanyRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    private ?string $string = null;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->navisionCompanyRepository = $this->getMockBuilder(NavisionCompanyRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->string = 'string';

        $this->companyReader = new CompanyReader($this->navisionCompanyRepository);
    }

    /**
     * @return void
     */
    public function testFindCompanyByExternalReference(): void
    {
        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('requireExternalReference')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn($this->string);

        $this->navisionCompanyRepository->expects($this->atLeastOnce())
            ->method('findCompanyByExternalReference')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->companyReader->findCompanyByExternalReference($this->companyTransferMock));
    }

    /**
     * @return void
     */
    public function testFindCompanyByDebtorNumber(): void
    {
        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('requireDebtorNumber')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getDebtorNumber')
            ->willReturn('xxxxx');

        $this->navisionCompanyRepository->expects($this->atLeastOnce())
            ->method('findCompanyByDebtorNumber')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(CompanyResponseTransfer::class, $this->companyReader->findCompanyByDebtorNumber($this->companyTransferMock));
    }
}
