<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Communication\Plugin\Api;

use FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiConfig;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\ApiExtension\Dependency\Plugin\ApiValidatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiConfig getConfig()
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacadeInterface getFacade()
 */
class ErpOrderCancellationApiValidatorPlugin extends AbstractPlugin implements ApiValidatorPluginInterface
{
    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return ErpOrderCancellationApiConfig::RESOURCE_ERP_ORDER_CANCELLATIONS;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFacade()->validateErpOrderCancellation($apiRequestTransfer);
    }
}
