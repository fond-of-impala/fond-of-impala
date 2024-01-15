<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReader
     */
    protected $companyReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->repositoryMock = $this->getMockBuilder(CompanyUserReferenceRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUserReferenceToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReader = new CompanyReader(
            $this->repositoryMock,
            $this->companyFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReference(): void
    {
        $idCompany = 1;
        $companyUserReference = 'FOO--CU-1';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findIdCompanyByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($idCompany);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyById')
            ->with($idCompany)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->companyReader->getByCompanyUserReference($companyUserReference),
        );
    }

    /**
     * @return void
     */
    public function testGetByCompanyUserReferenceWithoutResult(): void
    {
        $idCompany = null;
        $companyUserReference = 'FOO--CU-1';

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findIdCompanyByCompanyUserReference')
            ->with($companyUserReference)
            ->willReturn($idCompany);

        $this->companyFacadeMock->expects(static::never())
            ->method('findCompanyById');

        static::assertEquals(
            null,
            $this->companyReader->getByCompanyUserReference($companyUserReference),
        );
    }
}
