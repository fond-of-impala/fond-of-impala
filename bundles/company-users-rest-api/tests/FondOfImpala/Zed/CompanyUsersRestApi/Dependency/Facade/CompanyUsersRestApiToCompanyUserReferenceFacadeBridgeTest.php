<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUsersRestApiToCompanyUserReferenceFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeBridge
     */
    protected $companyUsersRestApiToCompanyUserReferenceFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserReferenceFacadeBridge = new CompanyUsersRestApiToCompanyUserReferenceFacadeBridge(
            $this->companyUserReferenceFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->companyUsersRestApiToCompanyUserReferenceFacadeBridge->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
