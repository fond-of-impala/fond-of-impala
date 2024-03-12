<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\Reducer;

class PriceDataReducerPluginExecutor implements PriceDataReducerPluginExecutorInterface
{
    /**
     * @var array<\FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface>
     */
    protected array $plugins;

    /**
     * @param array<\FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface> $plugins
     */
    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function execute(array $data): array
    {
        foreach ($this->plugins as $plugin) {
            $data = $plugin->reduce($data);
        }

        return $data;
    }
}
