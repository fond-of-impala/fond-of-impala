<?php

namespace FondOfImpala\Glue\BusinessCentralOrderBudgetsBulkRestApi\Plugin\OrderBudgetsBulkRestApiExtension;

use FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestCompanyTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class BusinessCentralRestOrderBudgetsBulkRequestOrderBudgetMapperPlugin extends AbstractPlugin implements RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer
     */
    public function mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
        RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer,
        RestOrderBudgetsBulkRequestOrderBudgetTransfer $restOrderBudgetsBulkRequestOrderBudgetTransfer
    ): RestOrderBudgetsBulkRequestOrderBudgetTransfer {
        $restOrderBudgetsBulkCompanyTransfer = $restOrderBudgetsBulkOrderBudgetTransfer->getCompany();

        if ($restOrderBudgetsBulkCompanyTransfer === null) {
            return $restOrderBudgetsBulkRequestOrderBudgetTransfer;
        }

        $restOrderBudgetsBulkRequestCompanyTransfer = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getCompany();

        if ($restOrderBudgetsBulkRequestCompanyTransfer === null) {
            $restOrderBudgetsBulkRequestCompanyTransfer = new RestOrderBudgetsBulkRequestCompanyTransfer();
        }

        $restOrderBudgetsBulkRequestCompanyTransfer->setDebtorNumber(
            $restOrderBudgetsBulkCompanyTransfer->getDebtorNumber()
        );

        return $restOrderBudgetsBulkRequestOrderBudgetTransfer->setCompany($restOrderBudgetsBulkRequestCompanyTransfer);
    }
}
