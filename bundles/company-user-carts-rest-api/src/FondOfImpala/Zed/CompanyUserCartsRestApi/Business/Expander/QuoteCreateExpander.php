<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteCreateExpander implements QuoteCreateExpanderInterface
{
    /**
     * @var array<\FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface>
     */
    protected array $plugins;

    /**
     * @param array<\FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface> $plugins
     */
    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        foreach ($this->plugins as $plugin) {
            $quoteTransfer = $plugin->expand($quoteTransfer, $restCompanyUserCartsRequestTransfer);
        }

        return $quoteTransfer;
    }
}
