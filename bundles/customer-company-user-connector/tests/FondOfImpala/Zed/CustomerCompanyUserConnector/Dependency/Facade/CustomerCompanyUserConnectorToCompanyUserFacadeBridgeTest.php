<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CustomerCompanyUserConnectorToCompanyUserFacadeBridgeTest extends Unit
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
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeBridge
     */
    protected CustomerCompanyUserConnectorToCompanyUserFacadeBridge $bridge;

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

        $this->bridge = new CustomerCompanyUserConnectorToCompanyUserFacadeBridge(
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
