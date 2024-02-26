<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiConfig;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class OrderBudgetsBulkResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
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
        return OrderBudgetsBulkRestApiConfig::RESOURCE_ORDER_BUDGETS_BULK;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return OrderBudgetsBulkRestApiConfig::CONTROLLER_ORDER_BUDGETS_BULK;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestOrderBudgetsBulkRequestAttributesTransfer::class;
    }
}
