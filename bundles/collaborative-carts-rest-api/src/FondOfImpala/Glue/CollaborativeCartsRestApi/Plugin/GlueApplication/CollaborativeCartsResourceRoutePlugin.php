<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Plugin\GlueApplication;

use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CollaborativeCartsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(
        ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        $resourceRouteCollection
            ->addPost(CollaborativeCartsRestApiConfig::ACTION_COLLABORATIVE_CARTS_POST, true);

        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceType(): string
    {
        return CollaborativeCartsRestApiConfig::RESOURCE_COLLABORATIVE_CARTS;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getController(): string
    {
        return CollaborativeCartsRestApiConfig::CONTROLLER_COLLABORATIVE_CARTS;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCollaborativeCartsRequestAttributesTransfer::class;
    }
}
