<?php

namespace FondOfImpala\Zed\CompanyTypeDataImport;

use Codeception\Test\Unit;
use Spryker\Shared\DataImport\DataImportConstants;

class CompanyTypeDataImportConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeDataImport\CompanyTypeDataImportConfig
     */
    protected $companyTypeDataImportConfig;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeDataImportConfig = new class () extends CompanyTypeDataImportConfig {
            /**
             * @param string $key
             * @param mixed|null $default
             *
             * @return mixed
             */
            protected function get($key, $default = null)
            {
                if ($key === DataImportConstants::IMPORT_FILE_ROOT_PATH) {
                    return $default;
                }

                return parent::get($key, $default);
            }
        };
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeDataImporterConfiguration(): void
    {
        $dataImporterConfigurationTransfer = $this->companyTypeDataImportConfig
            ->getCompanyTypeDataImporterConfiguration();

        $this->assertEquals(
            CompanyTypeDataImportConfig::IMPORT_TYPE_COMPANY_TYPE,
            $dataImporterConfigurationTransfer->getImportType(),
        );

        $this->assertNotNull(
            $dataImporterConfigurationTransfer->getReaderConfiguration(),
        );

        $this->assertEquals(
            codecept_root_dir('data/import/company_type.csv'),
            $dataImporterConfigurationTransfer->getReaderConfiguration()->getFileName(),
        );
    }
}
