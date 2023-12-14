<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyUserCompanyAssignerToCompanyUserFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyUserFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer
     */
    protected $companyUserCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

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
        $this->companyUserFacadeInterfaceMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCriteriaFilterTransferMock = $this->getMockBuilder(CompanyUserCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerToCompanyUserFacadeBridge = new CompanyUserCompanyAssignerToCompanyUserFacadeBridge(
            $this->companyUserFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyUserCollection(): void
    {
        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyUserCollection')
            ->with($this->companyUserCriteriaFilterTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->assertInstanceOf(
            CompanyUserCollectionTransfer::class,
            $this->companyUserCompanyAssignerToCompanyUserFacadeBridge->getCompanyUserCollection(
                $this->companyUserCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserCompanyAssignerToCompanyUserFacadeBridge->create(
                $this->companyUserTransferMock,
            ),
        );
    }
}
