<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence;

use Generated\Shared\Transfer\CustomerCollectionTransfer;

interface OrderConfirmationRecipientsOverrideRepositoryInterface
{
    /**
     * @param array $emails
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     */
    public function getAllowedCustomerCollectionByMails(array $emails): CustomerCollectionTransfer;
}
