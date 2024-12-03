<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig getConfig()
 */
abstract class AbstractRoleBasedErpOrderCancellationMailTypePlugin extends AbstractErpOrderCancellationMailTypePlugin
{
    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setRecipient(MailBuilderInterface $mailBuilder)
    {
        $mailTransfer = $mailBuilder->getMailTransfer();
        $config = $mailTransfer->requireErpOrderCancellationMailConfig()->getErpOrderCancellationMailConfig();

        $customerTransfer = $mailTransfer->getCustomer();
        $erpOrderCancellationTransfer = $config->getCancellation();

        $defaultMailAddress = null;
        if ($customerTransfer !== null) {
            $defaultMailAddress = $customerTransfer->getEmail();
            $recipient = (new MailRecipientTransfer())
                ->setEmail($defaultMailAddress)
                ->setName($customerTransfer->getFirstName() . ' ' . $customerTransfer->getLastName());
            $mailTransfer->addRecipient($recipient);
        }

        $rolesToNotify = $config->getRoleNames();

        if (count($rolesToNotify) === 0) {
            $rolesToNotify = $this->getConfig()->getRolesToNotify();
        }

        $bcc = $this->getRepository()->getMailAddressesByDebtorNumberAndRoleNames($erpOrderCancellationTransfer->getDebitorNumber(), $rolesToNotify);

        foreach ($bcc as $mailAddress) {
            if ($mailAddress === $defaultMailAddress) {
                continue;
            }
            $recipient = (new MailRecipientTransfer())
                ->setEmail($mailAddress);
            $mailTransfer->addRecipientBcc($recipient);
        }

        return $this;
    }
}
