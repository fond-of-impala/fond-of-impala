<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Plugin\ResourceRoute;

use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceWithParentPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory getFactory()
 */
class CompanyUserCartsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface, ResourceWithParentPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection
            ->addGet('get')
            ->addPost('post')
            ->addPatch('patch')
            ->addDelete('delete');

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyUserCartsRestApiConfig::CONTROLLER_CARTS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCartsRequestAttributesTransfer::class;
    }

    /**
     * @return string
     */
    public function getParentResourceType(): string
    {
        return CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS;
    }
}
