<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use Exception;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;

class ConditionalAvailabilityPeriodPageSearchExpander implements ConditionalAvailabilityPeriodPageSearchExpanderInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface>
     */
    protected array $conditionalAvailabilityPeriodPageDataExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface> $conditionalAvailabilityPeriodPageDataExpanderPlugins
     */
    public function __construct(
        array $conditionalAvailabilityPeriodPageDataExpanderPlugins
    ) {
        $this->conditionalAvailabilityPeriodPageDataExpanderPlugins = $conditionalAvailabilityPeriodPageDataExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    public function expand(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $conditionalAvailabilityPeriodPageSearchTransfer = $this->expandWithConditionalAvailabilityPeriodKey(
            $conditionalAvailabilityPeriodPageSearchTransfer,
        );

        foreach ($this->conditionalAvailabilityPeriodPageDataExpanderPlugins as $conditionalAvailabilityPeriodPageDataExpanderPlugin) {
            $conditionalAvailabilityPeriodPageSearchTransfer = $conditionalAvailabilityPeriodPageDataExpanderPlugin
                ->expand($conditionalAvailabilityPeriodPageSearchTransfer);
        }

        return $conditionalAvailabilityPeriodPageSearchTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected function expandWithConditionalAvailabilityPeriodKey(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $data = $conditionalAvailabilityPeriodPageSearchTransfer->getData();

        if (!isset($data['key'])) {
            throw new Exception('Key must exists...');
        }

        return $conditionalAvailabilityPeriodPageSearchTransfer->setConditionalAvailabilityPeriodKey($data['key']);
    }
}
