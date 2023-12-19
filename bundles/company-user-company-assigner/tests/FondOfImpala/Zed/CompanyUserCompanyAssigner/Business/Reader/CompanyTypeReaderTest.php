<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeReaderTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTypeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new CompanyTypeReader($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetManufacturerCompanyType(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getManufacturerCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        static::assertEquals(
            $this->companyTypeTransferMock,
            $this->reader->getManufacturerCompanyType(),
        );
    }

    /**
     * @return void
     */
    public function testGetByCompany(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        static::assertEquals(
            $this->companyTypeTransferMock,
            $this->reader->getByCompany($this->companyTransferMock),
        );
    }
}
