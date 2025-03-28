<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 */
class NotifyRejectedErpOrderCancellationMailTypePlugin extends AbstractErpOrderCancellationMailTypePlugin
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'mail.erp.order.cancellation.rejected';
}
