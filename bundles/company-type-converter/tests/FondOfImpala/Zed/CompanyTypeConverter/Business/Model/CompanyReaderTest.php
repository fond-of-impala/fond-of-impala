<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyReader
     */
    protected $companyReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReader = new CompanyReader($this->companyFacadeMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyReader->findCompanyById($this->companyTransferMock),
        );
    }
}
