<?php

namespace FondOfImpala\Zed\CompanyType;

use FondOfImpala\Shared\CompanyType\CompanyTypeConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyTypeConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const DEFAULT_COMPANY_TYPE_NAME = 'default';

    /**
     * @var string
     */
    protected const MANUFACTURER_COMPANY_TYPE_NAME = 'manufacturer';

    /**
     * @return string
     */
    public function getDefaultCompanyTypeName(): string
    {
        return $this->get(CompanyTypeConstants::DEFAULT_COMPANY_TYPE_NAME, static::DEFAULT_COMPANY_TYPE_NAME);
    }

    /**
     * @return string
     */
    public function getCompanyTypeManufacturer(): string
    {
        return $this->get(CompanyTypeConstants::MANUFACTURER_COMPANY_TYPE_NAME, static::MANUFACTURER_COMPANY_TYPE_NAME);
    }

    /**
     * @return array<string>
     */
    public function getValidCompanyTypesForExport(): array
    {
        return $this->get(CompanyTypeConstants::VALID_COMPANY_TYPES_FOR_EXPORT, []);
    }
}
