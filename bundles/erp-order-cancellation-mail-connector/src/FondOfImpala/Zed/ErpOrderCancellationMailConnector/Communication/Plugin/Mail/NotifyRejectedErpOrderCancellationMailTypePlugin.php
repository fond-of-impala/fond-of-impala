<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 */
class NotifyRejectedErpOrderCancellationMailTypePlugin extends AbstractErpOrderCancellationMailTypePlugin
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'notify-rejected-erp-order-cancellation';


    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSubject(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSubject('notify.rejected.erp.order.cancellation.subject');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setHtmlTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setHtmlTemplate('ErpOrderCancellationMailConnector/Presentation/Mail/notify_rejected_erp_order_cancellation.html.twig');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setTextTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setTextTemplate('ErpOrderCancellationMailConnector/Presentation/Mail/notify_rejected_erp_order_cancellation.text.twig');

        return $this;
    }
}
