<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi;

use FondOfImpala\Shared\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class ErpOrderCancellationRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return array<int>
     */
    public function getInternalCompanyTypeIds(): array
    {
        return $this->get(ErpOrderCancellationRestApiConstants::INTERNAL_COMPANY_TYPE_IDS, []);
    }
}
