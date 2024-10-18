<?php

namespace FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellationRestApiExtension;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Persistence\PermissionErpOrderCancellationRestApiRepositoryInterface getRepository()
 */
class PermissionReadErpOrderCancellationQueryExpanderPlugin extends AbstractPlugin implements ErpOrderCancellationQueryExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return bool
     */
    public function isApplicable(ErpOrderCancellationFilterTransfer $filterTransfer): bool
    {
        return true;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $query
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function expandErpOrderCancellationQuery(
        FoiErpOrderCancellationQuery $query,
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): FoiErpOrderCancellationQuery {
        $debtorNumbers = $filterTransfer->getDebitorNumbers();

        $debtorNumbersAvailable = $this->getRepository()->getDebtorNumbersByFkCustomer($filterTransfer->getFkOriginator());
        $allowedDebtorNumbers = [];

        if (count($debtorNumbers) === 0) {
            $allowedDebtorNumbers = $debtorNumbersAvailable;
        }

        foreach ($debtorNumbers as $debtorNumber) {
            if (in_array($debtorNumber, $debtorNumbersAvailable, true)) {
                $allowedDebtorNumbers[] = $debtorNumber;
            }
        }

        return $query->filterByDebitorNumber_In($allowedDebtorNumbers);
    }
}
