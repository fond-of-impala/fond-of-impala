<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUser\Business\Reader\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface
     */
    protected $navisionCompanyUserRepositoryMock;

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

        $this->navisionCompanyUserRepositoryMock = $this->getMockBuilder(NavisionCompanyUserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader($this->navisionCompanyUserRepositoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByExternalReference(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('string');

        $this->navisionCompanyUserRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByExternalReference')
            ->willReturn($this->companyUserTransferMock);

        $this->assertInstanceOf(CompanyUserResponseTransfer::class, $this->companyUserReader->findCompanyUserByExternalReference($this->companyUserTransferMock));
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByExternalReferenceNotSuccess(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('string');

        $this->navisionCompanyUserRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByExternalReference')
            ->willReturn(null);

        $this->assertInstanceOf(CompanyUserResponseTransfer::class, $this->companyUserReader->findCompanyUserByExternalReference($this->companyUserTransferMock));
    }
}
