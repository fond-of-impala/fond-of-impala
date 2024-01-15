<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUsersRestApiToCompanyUserReferenceClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientBridge
     */
    protected $companyUsersRestApiToCompanyUserReferenceClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceClientInterface
     */
    protected $companyUserReferenceClientInterfaceMock;

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
        $this->companyUserReferenceClientInterfaceMock = $this->getMockBuilder(CompanyUserReferenceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserReferenceClientBridge = new CompanyUsersRestApiToCompanyUserReferenceClientBridge(
            $this->companyUserReferenceClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiToCompanyUserReferenceClientBridge->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
