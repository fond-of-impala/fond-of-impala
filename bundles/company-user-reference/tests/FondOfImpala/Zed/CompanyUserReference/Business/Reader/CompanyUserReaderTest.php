<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $companyUserReferenceRepositoryInterfaceMock;

    /**
     * @var array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface>
     */
    protected $companyUserHydrationPlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var string
     */
    protected $companyUserReference;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface
     */
    private $companyUserHydrationPluginInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceRepositoryInterfaceMock = $this->getMockBuilder(CompanyUserReferenceRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserHydrationPluginInterfaceMock = $this->getMockBuilder(CompanyUserHydrationPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserHydrationPlugins = [
            $this->companyUserHydrationPluginInterfaceMock,
        ];

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReference = 'company-user-reference';

        $this->companyUserReader = new CompanyUserReader(
            $this->companyUserReferenceRepositoryInterfaceMock,
            $this->companyUserHydrationPlugins,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUserReferenceRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserReference)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserHydrationPluginInterfaceMock->expects($this->atLeastOnce())
            ->method('hydrate')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserReader->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReferenceCompanyUserNull(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUserReferenceRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserReference)
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserReader->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
