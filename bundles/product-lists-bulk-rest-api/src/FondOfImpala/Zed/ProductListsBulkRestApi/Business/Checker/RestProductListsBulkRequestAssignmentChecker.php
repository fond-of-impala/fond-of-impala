<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker;

use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class RestProductListsBulkRequestAssignmentChecker implements RestProductListsBulkRequestAssignmentCheckerInterface
{
    protected array $restProductListsBulkRequestAssignmentPreCheckPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface> $restProductListsBulkRequestAssignmentPreCheckPlugins
     */
    public function __construct(
        array $restProductListsBulkRequestAssignmentPreCheckPlugins = []
    ) {
        $this->restProductListsBulkRequestAssignmentPreCheckPlugins = $restProductListsBulkRequestAssignmentPreCheckPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return bool
     */
    public function preCheck(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): bool {
        $valid = false;

        foreach ($this->restProductListsBulkRequestAssignmentPreCheckPlugins as $plugin) {
            $preCheckResult = $plugin->check($restProductListsBulkRequestAssignmentTransfer);

            if (!$plugin->terminateOnFailure()) {
                $valid = $valid || $preCheckResult;

                continue;
            }

            if ($preCheckResult) {
                continue;
            }

            return false;
        }

        return $valid;
    }
}
