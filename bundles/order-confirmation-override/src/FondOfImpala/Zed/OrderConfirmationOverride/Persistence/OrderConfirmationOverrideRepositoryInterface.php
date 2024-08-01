<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Persistence;

use Generated\Shared\Transfer\CustomerCollectionTransfer;

interface OrderConfirmationOverrideRepositoryInterface
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
