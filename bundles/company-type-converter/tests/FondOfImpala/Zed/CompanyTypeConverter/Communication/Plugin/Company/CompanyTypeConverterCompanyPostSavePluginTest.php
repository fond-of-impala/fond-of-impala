<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacade;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyTypeConverterCompanyPostSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacade
     */
    protected $companyTypeConverterFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company\CompanyTypeConverterCompanyPostSavePlugin
     */
    protected $companyTypeConverterCompanyPostSavePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeConverterFacadeMock = $this->getMockBuilder(CompanyTypeConverterFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterCompanyPostSavePlugin = new CompanyTypeConverterCompanyPostSavePlugin();
        $this->companyTypeConverterCompanyPostSavePlugin->setFacade($this->companyTypeConverterFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostSave(): void
    {
        $idCompanyType = 2;
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($idCompanyType);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIsCompanyTypeModified')
            ->willReturn(true);

        $this->companyTypeConverterFacadeMock->expects($this->atLeastOnce())
            ->method('convertCompanyType')
            ->willReturn($this->companyResponseTransferMock);

        $companyResponseTransfer = $this->companyTypeConverterCompanyPostSavePlugin
            ->postSave($this->companyResponseTransferMock);

        $this->assertEquals($this->companyResponseTransferMock, $companyResponseTransfer);
    }
}
