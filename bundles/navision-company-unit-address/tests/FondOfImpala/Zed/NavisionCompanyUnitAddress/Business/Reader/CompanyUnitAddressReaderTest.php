<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepositoryInterface;
use Generated\Shared\Transfer\CompanyUnitAddressResponseTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;

class CompanyUnitAddressReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompanyUnitAddress\Business\Reader\CompanyUnitAddressReader
     */
    protected $companyUnitAddressReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepositoryInterface
     */
    protected $navisionCompanyUnitAddressRepositoryMock;

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

        $this->navisionCompanyUnitAddressRepositoryMock = $this->getMockBuilder(NavisionCompanyUnitAddressRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddressTransferMock = $this->getMockBuilder(CompanyUnitAddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddressReader = new CompanyUnitAddressReader($this->navisionCompanyUnitAddressRepositoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyUnitAddressByExternalReference(): void
    {
        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('string');

        $this->navisionCompanyUnitAddressRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUnitAddressByExternalReference')
            ->willReturn($this->companyUnitAddressTransferMock);

        $this->assertInstanceOf(CompanyUnitAddressResponseTransfer::class, $this->companyUnitAddressReader->findCompanyUnitAddressByExternalReference($this->companyUnitAddressTransferMock));
    }

    /**
     * @return void
     */
    public function testFindCompanyUnitAddressByExternalReferenceNotSuccessful(): void
    {
        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('string');

        $this->navisionCompanyUnitAddressRepositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUnitAddressByExternalReference')
            ->willReturn(null);

        $this->assertInstanceOf(CompanyUnitAddressResponseTransfer::class, $this->companyUnitAddressReader->findCompanyUnitAddressByExternalReference($this->companyUnitAddressTransferMock));
    }
}
