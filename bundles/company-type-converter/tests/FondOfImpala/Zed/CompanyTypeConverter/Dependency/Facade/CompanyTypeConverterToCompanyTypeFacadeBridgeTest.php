<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeConverterToCompanyTypeFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    protected $companyTypeResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeBridge
     */
    protected $companyTypeConverterToCompanyTypeFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyTypeFacadeBridge = new CompanyTypeConverterToCompanyTypeFacadeBridge(
            $this->companyTypeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyTypeById(): void
    {
        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeResponseTransferMock);

        $companyTypeResponseTransfer = $this->companyTypeConverterToCompanyTypeFacadeBridge
            ->findCompanyTypeById($this->companyTypeTransferMock);

        $this->assertEquals($this->companyTypeResponseTransferMock, $companyTypeResponseTransfer);
        $this->assertInstanceOf(
            CompanyTypeResponseTransfer::class,
            $companyTypeResponseTransfer,
        );
    }
}
