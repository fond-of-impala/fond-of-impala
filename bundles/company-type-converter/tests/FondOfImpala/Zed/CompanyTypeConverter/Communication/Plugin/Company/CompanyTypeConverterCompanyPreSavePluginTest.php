<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeConverter\Business\CompanyTypeConverterFacade;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyTypeConverterCompanyPreSavePluginTest extends Unit
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
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeTransfer|MockObject $companyTypeTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Communication\Plugin\Company\CompanyTypeConverterCompanyPreSavePlugin
     */
    protected $companyTypeConverterCompanyPreSavePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $currentCompanyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTypeConverterConfig|MockObject $configMock;

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

        $this->configMock = $this->getMockBuilder(CompanyTypeConverterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getFkCompanyType', 'getIdCompany', 'setIsCompanyTypeModified', 'setFkOldCompanyType'])
            ->getMock();

        $this->currentCompanyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterCompanyPreSavePlugin = new CompanyTypeConverterCompanyPreSavePlugin();
        $this->companyTypeConverterCompanyPreSavePlugin->setFacade($this->companyTypeConverterFacadeMock);
        $this->companyTypeConverterCompanyPreSavePlugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testPreSaveValidation(): void
    {
        $idCompanyType = 2;
        $idCompany = 1;
        $currentIdCompanyType = 1;
        $key = 'manufacturer';

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($idCompanyType);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->companyTypeConverterFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->currentCompanyTransferMock);

        $this->companyTypeConverterFacadeMock->expects($this->atLeastOnce())
            ->method('isTypeConvertable')
            ->willReturn(true);

        $this->currentCompanyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($currentIdCompanyType);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('setIsCompanyTypeModified')
            ->with(true);

        $this->companyTypeConverterCompanyPreSavePlugin
            ->preSaveValidation($this->companyResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testPreSaveValidationBlacklistedKey(): void
    {
        $idCompanyType = 2;
        $idCompany = 1;
        $currentIdCompanyType = 1;
        $key = 'manufacturer';

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($idCompanyType);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->companyTypeConverterFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyById')
            ->willReturn($this->currentCompanyTransferMock);

        $this->companyTypeConverterFacadeMock->expects($this->atLeastOnce())
            ->method('isTypeConvertable')
            ->willReturn(false);

        $this->currentCompanyTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyType')
            ->willReturn($currentIdCompanyType);

        $this->currentCompanyTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($key);

        $this->companyTransferMock->expects($this->never())
            ->method('setIsCompanyTypeModified');

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('setIsSuccessful')
            ->with(false)
            ->willReturnSelf();

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('addMessage')
            ->willReturnSelf();

        $this->companyTypeConverterCompanyPreSavePlugin
            ->preSaveValidation($this->companyResponseTransferMock);
    }
}
