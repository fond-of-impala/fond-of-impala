<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiConfig;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class PriceListResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(
        ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        return $resourceRouteCollection
            ->addGet(PriceListsRestApiConfig::ACTION_PRICE_LISTS_GET, true);
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return PriceListsRestApiConfig::RESOURCE_PRICE_LISTS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return PriceListsRestApiConfig::CONTROLLER_PRICE_LISTS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestPriceListAttributesTransfer::class;
    }
}
