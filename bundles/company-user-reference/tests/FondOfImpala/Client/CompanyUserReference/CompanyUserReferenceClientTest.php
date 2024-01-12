<?php

namespace FondOfImpala\Client\CompanyUserReference;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStubInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReferenceClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceClient
     */
    protected $companyUserReferenceClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserReference\CompanyUserReferenceFactory
     */
    protected $companyUserReferenceFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyUserReference\Zed\CompanyUserReferenceStubInterface
     */
    protected $companyUserReferenceStubInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceFactoryMock = $this->getMockBuilder(CompanyUserReferenceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceStubInterfaceMock = $this->getMockBuilder(CompanyUserReferenceStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceClient = new CompanyUserReferenceClient();
        $this->companyUserReferenceClient->setFactory($this->companyUserReferenceFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceFactoryMock->expects($this->atLeastOnce())
            ->method('createZedCompanyUserReferenceStub')
            ->willReturn($this->companyUserReferenceStubInterfaceMock);

        $this->companyUserReferenceStubInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserReferenceClient->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
