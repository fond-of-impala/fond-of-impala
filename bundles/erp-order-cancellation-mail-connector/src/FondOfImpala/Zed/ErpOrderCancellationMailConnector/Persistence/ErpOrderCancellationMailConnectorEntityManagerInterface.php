<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;

/**
 * @codeCoverageIgnore
 */
interface ErpOrderCancellationMailConnectorEntityManagerInterface
{
    /**
     * @param int $idErpOrderCancellation
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function removeNotificationRecipientsForErpOrderCancellation(int $idErpOrderCancellation): void;

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function createNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): ErpOrderCancellationNotifyTransfer;

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function deleteNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): void;
}
