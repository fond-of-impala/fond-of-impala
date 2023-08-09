<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\ProductPageSearch\Elasticsearch;

use Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

class ConditionalAvailabilityMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const KEY_CONDITIONAL_AVAILABILITY_MAP = 'conditional_availability_map';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array<string, mixed> $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        if (!isset($productData[static::KEY_CONDITIONAL_AVAILABILITY_MAP])) {
            return $pageMapTransfer;
        }
        $conditionalAvailabilitMap = $this->getConditionlAvailabilitySearchData($productData);
        $pageMapTransfer->setConditionalAvailabilities($conditionalAvailabilitMap);

        return $pageMapTransfer;
    }

    /**
     * @param array<string, mixed> $productData
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityMapTransfer
     */
    protected function getConditionlAvailabilitySearchData(array $productData): ConditionalAvailabilityMapTransfer
    {
        $conditionalAvailabilityMapTransfer = new ConditionalAvailabilityMapTransfer();
        $conditionalAvailabilityMapTransfer->fromArray($productData[static::KEY_CONDITIONAL_AVAILABILITY_MAP]);

        return $conditionalAvailabilityMapTransfer;
    }
}
