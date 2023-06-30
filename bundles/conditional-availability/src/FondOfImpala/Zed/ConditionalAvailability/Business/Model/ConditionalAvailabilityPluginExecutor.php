<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;

class ConditionalAvailabilityPluginExecutor implements ConditionalAvailabilityPluginExecutorInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface>
     */
    protected array $conditionalAvailabilityPostSavePlugins;

    /**
     * @param array<\FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface> $conditionalAvailabilityPostSavePlugins
     */
    public function __construct(
        array $conditionalAvailabilityPostSavePlugins
    ) {
        $this->conditionalAvailabilityPostSavePlugins = $conditionalAvailabilityPostSavePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function executePostSavePlugins(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer {
        foreach ($this->conditionalAvailabilityPostSavePlugins as $conditionalAvailabilityPostSavePlugin) {
            $conditionalAvailabilityResponseTransfer = $conditionalAvailabilityPostSavePlugin
                ->postSave($conditionalAvailabilityResponseTransfer);
        }

        return $conditionalAvailabilityResponseTransfer;
    }
}
