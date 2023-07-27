<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CompanyUsersBulkResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        return $resourceRouteCollection->addPost('post');
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyUsersBulkRestApiConfig::RESOURCE_COMPANY_USERS_BULK;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyUsersBulkRestApiConfig::CONTROLLER_COMPANY_USERS_BULK;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCompanyUsersBulkRequestAttributesTransfer::class;
    }
}
