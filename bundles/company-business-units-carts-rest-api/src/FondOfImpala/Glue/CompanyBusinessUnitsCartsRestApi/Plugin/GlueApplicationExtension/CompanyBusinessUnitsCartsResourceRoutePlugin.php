<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceWithParentPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CompanyBusinessUnitsCartsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface, ResourceWithParentPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection
            ->addGet('get');

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyBusinessUnitsCartsRestApiConfig::CONTROLLER_COMPANY_BUSINESS_UNITS_CARTS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCartsAttributesTransfer::class;
    }

    /**
     * @return string
     */
    public function getParentResourceType(): string
    {
        return CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS;
    }
}
