<?php

namespace FondOfImpala\Zed\CompanyTypeDataImport\Communication\Plugin\DataImport;

use FondOfImpala\Zed\CompanyTypeDataImport\CompanyTypeDataImportConfig;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyTypeDataImport\CompanyTypeDataImportConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyTypeDataImport\Business\CompanyTypeDataImportFacadeInterface getFacade()
 */
class CompanyTypeDataImportPlugin extends AbstractPlugin implements DataImportPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFacade()->importCompanyTypes($dataImporterConfigurationTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function getImportType(): string
    {
        return CompanyTypeDataImportConfig::IMPORT_TYPE_COMPANY_TYPE;
    }
}
