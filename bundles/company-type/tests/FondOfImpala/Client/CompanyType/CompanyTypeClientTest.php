<?php

namespace FondOfImpala\Client\CompanyType;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyType\Zed\CompanyTypeStubInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyType\CompanyTypeClient
     */
    protected $companyTypeClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyType\CompanyTypeFactory
     */
    protected $companyTypeFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyType\Zed\CompanyTypeStubInterface
     */
    protected $companyTypeStubInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTypeFactoryMock = $this->getMockBuilder(CompanyTypeFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeStubInterfaceMock = $this->getMockBuilder(CompanyTypeStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeClient = new CompanyTypeClient();
        $this->companyTypeClient->setFactory($this->companyTypeFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyTypeById(): void
    {
        $this->companyTypeFactoryMock->expects($this->atLeastOnce())
            ->method('createZedCompanyTypeStub')
            ->willReturn($this->companyTypeStubInterfaceMock);

        $this->companyTypeStubInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->assertInstanceOf(
            CompanyTypeResponseTransfer::class,
            $this->companyTypeClient->findCompanyTypeById(
                $this->companyTypeTransferMock,
            ),
        );
    }
}
