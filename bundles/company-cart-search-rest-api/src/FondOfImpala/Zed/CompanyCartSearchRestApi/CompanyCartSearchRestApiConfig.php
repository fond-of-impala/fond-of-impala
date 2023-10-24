<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi;

use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class CompanyCartSearchRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return array<string>
     */
    public function getNotAllowedFilterFieldTypesForCustomerFilter(): array
    {
        return [
            CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_COMPANY_UUID,
        ];
    }
}
