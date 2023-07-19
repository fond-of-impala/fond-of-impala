<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserResponseTransfer|MockObject $companyUserResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCriteriaFilterTransfer|MockObject $companyUserCriteriaFilterTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserCollectionTransfer $companyUserCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeBridge
     */
    protected CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCriteriaFilterTransferMock = $this->getMockBuilder(CompanyUserCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUser(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->bridge->deleteCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }
}
