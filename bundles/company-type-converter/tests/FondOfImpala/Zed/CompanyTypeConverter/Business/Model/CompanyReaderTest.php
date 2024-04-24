<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeConverterToCompanyTypeFacadeInterface|MockObject $companyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeTransfer|MockObject $companyTypeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeResponseTransfer|MockObject $companyTypeResponseTransferMock;

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

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyTypeConverterToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeResponseTransferMock = $this->getMockBuilder(CompanyTypeResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyReader = new CompanyReader($this->companyFacadeMock, $this->companyTypeFacadeMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyById(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn(1);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyReader->findCompanyById($this->companyTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyByIdAndAppendCompanyTypeTransferToCustomerTransfer(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn(1);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeTransfer')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyType')
            ->with($this->companyTypeTransferMock)
            ->willReturnSelf();

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyReader->findCompanyById($this->companyTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyByIdAndDoesNotFindTypeById(): void
    {
        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyById')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn(1);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn(null);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->willReturn($this->companyTypeResponseTransferMock);

        $this->companyTypeResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->companyTransferMock->expects($this->never())
            ->method('setCompanyType');

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyReader->findCompanyById($this->companyTransferMock),
        );
    }
}
