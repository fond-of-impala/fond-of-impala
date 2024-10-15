<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConfig;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class ErpOrderCancellationRestApiResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        return $resourceRouteCollection
            ->addPost('add')
            ->addPatch('patch')
            ->addDelete('delete')
            ->addGet('get');
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return ErpOrderCancellationRestApiConfig::RESOURCE_ERP_ORDER_CANCELLATION_REST_API;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return ErpOrderCancellationRestApiConfig::CONTROLLER_RESOURCE_ERP_ORDER_CANCELLATION_REST_API;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestErpOrderCancellationAttributesTransfer::class;
    }
}
