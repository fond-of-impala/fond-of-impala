<?php

namespace FondOfImpala\Client\EnhancedCatalog;

use FondOfImpala\Client\EnhancedCatalog\Formatter\RawCatalogSearchResultFormatter;
use FondOfImpala\Client\EnhancedCatalog\Formatter\RawCatalogSearchResultFormatterInterface;
use Spryker\Client\Kernel\AbstractFactory;

class EnhancedCatalogFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\EnhancedCatalog\Formatter\RawCatalogSearchResultFormatterInterface
     */
    public function createRawCatalogSearchResultFormatter(): RawCatalogSearchResultFormatterInterface
    {
        return new RawCatalogSearchResultFormatter(
            $this->getProductExpanderPlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface>
     */
    protected function getProductExpanderPlugins(): array
    {
        return $this->getProvidedDependency(EnhancedCatalogDependencyProvider::PLUGINS_PRODUCT_EXPANDER);
    }
}
