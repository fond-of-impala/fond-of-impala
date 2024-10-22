<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig getConfig()
 */
class NotifyApprovedErpOrderCancellationMailTypePlugin extends AbstractErpOrderCancellationMailTypePlugin
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'notify-approved-erp-order-cancellation';


    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSubject(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSubject('notify.approved.erp.order.cancellation.subject');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setHtmlTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setHtmlTemplate('ErpOrderCancellationMailConnector/Presentation/Mail/notify_approved_erp_order_cancellation.html.twig');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setTextTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setTextTemplate('ErpOrderCancellationMailConnector/Presentation/Mail/notify_approved_erp_order_cancellation.text.twig');

        return $this;
    }
}
