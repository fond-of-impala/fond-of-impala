<?php

declare(strict_types = 1);

namespace FondOfImpala\Glue\CartValidation\Plugin\GlueApplicationExtension;

use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\CartValidation\CartValidationFactory getFactory()
 */
class CartValidationMessageTranslatorRelationshipPlugin extends AbstractPlugin implements ResourceRelationshipPluginInterface
{
    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        $this->getFactory()
            ->createValidationMessageTranslator()
            ->translate($resources);
    }

    /**
     * @return string
     */
    public function getRelationshipResourceType(): string
    {
        return CartsRestApiConfig::RESOURCE_CARTS;
    }
}
