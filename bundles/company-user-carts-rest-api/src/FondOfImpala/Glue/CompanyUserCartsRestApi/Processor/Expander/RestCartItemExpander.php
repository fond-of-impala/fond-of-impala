<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander;

use Generated\Shared\Transfer\RestCartItemTransfer;

class RestCartItemExpander implements RestCartItemExpanderInterface
{
    /**
     * @var array<\FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface>
     */
    protected $restCartItemExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface> $restCartItemExpanderPlugins
     */
    public function __construct(array $restCartItemExpanderPlugins)
    {
        $this->restCartItemExpanderPlugins = $restCartItemExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartItemTransfer
     */
    public function expand(RestCartItemTransfer $restCartItemTransfer): RestCartItemTransfer
    {
        foreach ($this->restCartItemExpanderPlugins as $restCartItemExpanderPlugin) {
            $restCartItemTransfer = $restCartItemExpanderPlugin->expand($restCartItemTransfer);
        }

        return $restCartItemTransfer;
    }
}
