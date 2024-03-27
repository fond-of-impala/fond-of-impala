<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\CustomerAppRestApi\CustomerAppRestApiConfig;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CustomerAppResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
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
            ->addPatch(CustomerAppRestApiConfig::ACTION_CUSTOMER_APP_PATCH, true);
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CustomerAppRestApiConfig::RESOURCE_CUSTOMER_APP;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CustomerAppRestApiConfig::CONTROLLER_CUSTOMER_APP;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerAppRequestAttributesTransfer::class;
    }
}
