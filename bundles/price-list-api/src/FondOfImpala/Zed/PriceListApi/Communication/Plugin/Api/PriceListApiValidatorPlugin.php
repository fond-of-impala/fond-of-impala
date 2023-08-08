<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api;

use FondOfImpala\Zed\PriceListApi\PriceListApiConfig;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\ApiExtension\Dependency\Plugin\ApiValidatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceListApi\PriceListApiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface getQueryContainer()
 */
class PriceListApiValidatorPlugin extends AbstractPlugin implements ApiValidatorPluginInterface
{
    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return PriceListApiConfig::RESOURCE_PRICE_LISTS;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFacade()->validate($apiRequestTransfer);
    }
}
