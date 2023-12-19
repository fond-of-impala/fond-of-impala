<?php

namespace FondOfImpala\Zed\CompanyTypeDataImport\Communication\Plugin\DataImport;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeDataImport\Business\CompanyTypeDataImportFacade;
use FondOfImpala\Zed\CompanyTypeDataImport\CompanyTypeDataImportConfig;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;

class CompanyTypeDataImportPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeDataImport\Business\CompanyTypeDataImportFacade
     */
    protected $companyTypeDataImportFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    protected $dataImporterConfigurationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DataImporterReportTransfer
     */
    protected $dataImporterReportTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeDataImport\Communication\Plugin\DataImport\CompanyTypeDataImportPlugin
     */
    protected $companyTypeDataImportPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeDataImportFacadeMock = $this->getMockBuilder(CompanyTypeDataImportFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataImporterConfigurationTransferMock = $this->getMockBuilder(DataImporterConfigurationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataImporterReportTransferMock = $this->getMockBuilder(DataImporterReportTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeDataImportPlugin = new CompanyTypeDataImportPlugin();

        $this->companyTypeDataImportPlugin->setFacade($this->companyTypeDataImportFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetImportType(): void
    {
        $this->assertEquals(
            CompanyTypeDataImportConfig::IMPORT_TYPE_COMPANY_TYPE,
            $this->companyTypeDataImportPlugin->getImportType(),
        );
    }

    /**
     * @return void
     */
    public function testImport(): void
    {
        $this->companyTypeDataImportFacadeMock->expects($this->atLeastOnce())
            ->method('importCompanyTypes')
            ->with($this->dataImporterConfigurationTransferMock)
            ->willReturn($this->dataImporterReportTransferMock);

        $this->assertEquals(
            $this->dataImporterReportTransferMock,
            $this->companyTypeDataImportPlugin->import($this->dataImporterConfigurationTransferMock),
        );
    }
}
