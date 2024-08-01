<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Persistence;

use Generated\Shared\Transfer\CustomerCollectionTransfer;

interface OrderConfirmationOverrideRepositoryInterface
{
    /**
     * @param array $emails
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAllowedCustomerCollectionByMails(array $emails): CustomerCollectionTransfer;
}
