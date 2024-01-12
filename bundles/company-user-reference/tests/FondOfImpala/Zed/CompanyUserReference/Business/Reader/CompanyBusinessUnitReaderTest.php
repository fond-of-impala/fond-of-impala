<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyBusinessUnitReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReader
     */
    protected $companyBusinessUnitReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUserReferenceToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitReader = new CompanyBusinessUnitReader(
            $this->repositoryMock,
            $this->companyBusinessUnitFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReference(): void
    {
        $idCompanyBusinessUnit = 1;
        $companyUserReference = 'FOO--CU-1';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findIdCompanyBusinessUnitByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($idCompanyBusinessUnit);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyBusinessUnitById')
            ->with($idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $this->companyBusinessUnitReader->getByCompanyUserReference($companyUserReference),
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReferenceWithoutResult(): void
    {
        $idCompanyBusinessUnit = null;
        $companyUserReference = 'FOO--CU-1';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findIdCompanyBusinessUnitByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($idCompanyBusinessUnit);

        $this->companyBusinessUnitFacadeMock->expects(static::never())
            ->method('findCompanyBusinessUnitById');

        static::assertEquals(
            null,
            $this->companyBusinessUnitReader->getByCompanyUserReference($companyUserReference),
        );
    }
}
