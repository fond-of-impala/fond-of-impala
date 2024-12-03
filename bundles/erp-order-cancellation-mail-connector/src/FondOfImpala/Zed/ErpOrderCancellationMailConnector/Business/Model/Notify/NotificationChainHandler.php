<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Notify;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorEntityManagerInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class NotificationChainHandler implements NotificationChainHandlerInterface
{
    protected ErpOrderCancellationMailConnectorRepositoryInterface $repository;

    protected ErpOrderCancellationMailConnectorEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorEntityManagerInterface $entityManager
     */
    public function __construct(
        ErpOrderCancellationMailConnectorRepositoryInterface $repository,
        ErpOrderCancellationMailConnectorEntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function handleNotificationChain(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        if ($erpOrderCancellationTransfer->getNotify()->count() === 0) {
            return $erpOrderCancellationTransfer;
        }

        $mailAddresses = [];
        foreach ($erpOrderCancellationTransfer->getNotify() as $notify) {
            $mailAddresses[] = $notify->getEmailOrFail();
        }

        $customerCollectionTransfer = $this->repository->getCustomerCollectionByMail($mailAddresses);

        $currentChain = [];
        $dbNotifications = $this->repository->getNotificationChainByIdErpOrderCancellation($erpOrderCancellationTransfer->getIdErpOrderCancellation());
        foreach ($dbNotifications as $currentNotify) {
            $currentChain[$currentNotify->getFkCustomer()] = $currentNotify;
        }

        $new = [];
        $notifyCollection = new ArrayObject();
        foreach ($customerCollectionTransfer->getCustomers() as $customerTransfer) {
            if (array_key_exists($customerTransfer->getIdCustomer(), $currentChain)) {
                $notifyCollection->append($currentChain[$customerTransfer->getIdCustomer()]);
                unset($currentChain[$customerTransfer->getIdCustomer()]);

                continue;
            }
            $new[$customerTransfer->getIdCustomer()] = $customerTransfer;
        }

        foreach ($new as $customerTransfer) {
            $notifyTransfer = $this->entityManager->createNotificationChainEntry($erpOrderCancellationTransfer->getIdErpOrderCancellation(), $customerTransfer->getIdCustomer());
            $notifyCollection->append($notifyTransfer);
        }

        foreach ($currentChain as $customerTransfer) {
            $this->entityManager->deleteNotificationChainEntry($erpOrderCancellationTransfer->getIdErpOrderCancellation(), $customerTransfer->getFkErpOrderCancellation());
        }

        return $erpOrderCancellationTransfer->setNotify($notifyCollection);
    }
}
