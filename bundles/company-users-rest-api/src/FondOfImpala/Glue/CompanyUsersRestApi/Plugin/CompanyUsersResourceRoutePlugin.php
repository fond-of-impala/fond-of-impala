<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi\Plugin;

use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CompanyUsersResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        return $resourceRouteCollection
            ->addGet('get')
            ->addPost('post')
            ->addPatch('patch')
            ->addDelete('delete');
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyUsersRestApiConfig::CONTROLLER_COMPANY_USERS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCompanyUsersRequestAttributesTransfer::class;
    }
}
