<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiConfig;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class ProductListsBulkResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
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
        return ProductListsBulkRestApiConfig::RESOURCE_PRODUCT_LISTS_BULK;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return ProductListsBulkRestApiConfig::CONTROLLER_PRODUCT_LISTS_BULK;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestProductListsBulkRequestAttributesTransfer::class;
    }
}
