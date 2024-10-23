<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Mail\Dependency\Plugin\MailTypePluginInterface;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig getConfig()
 */
abstract class AbstractErpOrderCancellationMailTypePlugin extends AbstractPlugin implements MailTypePluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'mail.erp.order.cancellation';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::MAIL_TYPE;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return void
     */
    public function build(MailBuilderInterface $mailBuilder): void
    {
        $this
            ->setSubject($mailBuilder)
            ->setHtmlTemplate($mailBuilder)
            ->setTextTemplate($mailBuilder)
            ->setRecipient($mailBuilder)
            ->setSender($mailBuilder);
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSubject(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSubject(sprintf('%s.subject', $this->getName()));

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setHtmlTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setHtmlTemplate('ErpOrderCancellationMailConnector/Mail/notify_erp_order_cancellation.html.twig');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setTextTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setTextTemplate('ErpOrderCancellationMailConnector/Mail/notify_erp_order_cancellation.text.twig');

        return $this;
    }

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

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSender(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSender('mail.sender.email', 'mail.sender.name');

        return $this;
    }
}
