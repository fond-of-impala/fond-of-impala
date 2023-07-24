<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyTypeRoleToCompanyUserFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface|mixed
     */
    protected $companyUserFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserCriteriaFilterTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeBridge
     */
    protected $companyTypeRoleToCompanyUserFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
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

        $this->companyTypeRoleToCompanyUserFacadeBridge = new CompanyTypeRoleToCompanyUserFacadeBridge(
            $this->companyUserFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyUserCollection(): void
    {
        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyUserCollection')
            ->with($this->companyUserCriteriaFilterTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        static::assertEquals(
            $this->companyUserCollectionTransferMock,
            $this->companyTypeRoleToCompanyUserFacadeBridge->getCompanyUserCollection(
                $this->companyUserCriteriaFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserById(): void
    {
        $idCompanyUser = 1;

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserById')
            ->with($idCompanyUser)
            ->willReturn($this->companyUserTransferMock);

        static::assertEquals(
            $this->companyUserTransferMock,
            $this->companyTypeRoleToCompanyUserFacadeBridge->findCompanyUserById(
                $this->companyUserTransferMock,
            ),
        );
    }
}
