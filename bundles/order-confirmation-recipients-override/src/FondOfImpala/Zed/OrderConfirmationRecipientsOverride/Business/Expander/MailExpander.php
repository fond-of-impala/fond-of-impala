<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConfig;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence\OrderConfirmationRecipientsOverrideRepositoryInterface;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class MailExpander implements MailExpanderInterface
{
    protected OrderConfirmationRecipientsOverrideRepositoryInterface $repository;

    protected OrderConfirmationRecipientsOverrideConfig $config;

    /**
     * @param \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence\OrderConfirmationRecipientsOverrideRepositoryInterface $repository
     * @param \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConfig $config
     */
    public function __construct(OrderConfirmationRecipientsOverrideRepositoryInterface $repository, OrderConfirmationRecipientsOverrideConfig $config)
    {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expand(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer
    {
        if ($orderTransfer->getPreventCustomerOrderConfirmationMail() === false) {
            return $mailTransfer;
        }

        $currentRecipientCollection = $this->collectCurrentRecipients($mailTransfer);
        $allowedRecipients = $this->getAllowedRecipients(array_keys($currentRecipientCollection));

        $newRecipients = $this->buildNewRecipients($mailTransfer->getRecipients(), $currentRecipientCollection, $allowedRecipients);
        $newBccRecipients = $this->buildNewRecipients($mailTransfer->getRecipientBccs(), $currentRecipientCollection, $allowedRecipients);

        if ($newRecipients->count() === 0 && $newBccRecipients->count() > 0) {
            $newRecipients->append($newBccRecipients->offsetGet(0));
            $newBccRecipients->offsetUnset(0);
        }

        return $mailTransfer
            ->setRecipients($this->addFallbackRecipient($newRecipients))
            ->setRecipientBccs($newBccRecipients);
    }

    /**
     * @param array<string> $emailAddresses
     *
     * @return array<string>
     */
    protected function getAllowedRecipients(array $emailAddresses): array
    {
        $allowedRecipients = $this->repository->getAllowedCustomerCollectionByMails($emailAddresses);
        $allowedEmailAddresses = [];
        foreach ($allowedRecipients->getCustomers() as $customer) {
            $allowedEmailAddresses[] = strtolower($customer->getEmail());
        }

        return $allowedEmailAddresses;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return array<string, \Generated\Shared\Transfer\MailRecipientTransfer>
     */
    protected function collectCurrentRecipients(MailTransfer $mailTransfer): array
    {
        return array_merge(
            $this->prepareRecipientsData($mailTransfer->getRecipients()),
            $this->prepareRecipientsData($mailTransfer->getRecipientBccs()),
        );
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\MailRecipientTransfer> $mailRecipientTransfers
     *
     * @return array<string, \Generated\Shared\Transfer\MailRecipientTransfer>
     */
    protected function prepareRecipientsData(ArrayObject $mailRecipientTransfers): array
    {
        $mails = [];
        foreach ($mailRecipientTransfers as $recipient) {
            $mails[strtolower($recipient->getEmail())] = $recipient;
        }

        return $mails;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\MailRecipientTransfer> $currentRecipients
     * @param array<string, \Generated\Shared\Transfer\MailRecipientTransfer> $mails
     * @param array<string> $allowedRecipients
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\MailRecipientTransfer>
     */
    protected function buildNewRecipients(ArrayObject $currentRecipients, array $mails, array $allowedRecipients): ArrayObject
    {
        $newRecipients = new ArrayObject();
        foreach ($currentRecipients as $recipient) {
            $email = strtolower($recipient->getEmail());
            if (array_key_exists($email, $mails) && in_array($email, $allowedRecipients)) {
                $newRecipients->append($mails[$email]);
            }
        }

        return $newRecipients;
    }

    /**
     * @param \ArrayObject $newRecipients
     *
     * @return \ArrayObject
     */
    protected function addFallbackRecipient(ArrayObject $newRecipients): ArrayObject
    {
        if ($newRecipients->count() === 0) {
            $fallbackRecipient = (new MailRecipientTransfer())->setEmail($this->config->getFallbackRecipientMailAddress());
            $newRecipients->append($fallbackRecipient);
        }

        return $newRecipients;
    }
}
