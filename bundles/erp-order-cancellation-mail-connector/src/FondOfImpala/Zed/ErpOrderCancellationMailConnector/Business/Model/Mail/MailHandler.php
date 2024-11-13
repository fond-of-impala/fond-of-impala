<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Psr\Log\LoggerInterface;
use Throwable;

class MailHandler implements MailHandlerInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface
     */
    protected ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface
     */
    protected ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface
     */
    protected ErpOrderCancellationMailConnectorRepositoryInterface $repository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacade
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ErpOrderCancellationMailConnectorRepositoryInterface $repository,
        ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacade,
        ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacade,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->mailFacade = $mailFacade;
        $this->localeFacade = $localeFacade;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function sendMail(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer
    {
        $response = (new ErpOrderCancellationMailConfigResponseTransfer())
            ->setIsSuccessful(false)
            ->setConfig($erpOrderCancellationMailConfigTransfer);

        try {
            $mailTransfer = new MailTransfer();
            $mailTransfer->setType($erpOrderCancellationMailConfigTransfer->getTypeOrFail());

            $customerTransfer = $erpOrderCancellationMailConfigTransfer->getRecipient();
            if ($customerTransfer === null) {
                $customerTransfer = $this->repository->getCustomerByIdCustomer($erpOrderCancellationMailConfigTransfer->getCancellation()->getFkCustomerRequested());
                $mailTransfer->setCustomer($customerTransfer);
            }

            $mailTransfer->setLocale($this->localeFacade->getLocaleById($customerTransfer->getFkLocale()))
               ->setErpOrderCancellationMailConfig($erpOrderCancellationMailConfigTransfer);

            $this->mailFacade->handleMail($mailTransfer);
            $response->setMail($mailTransfer);
        } catch (Throwable $exception) {
            $this->logger->error(sprintf('Error while sending cancellation %s mail: %s', $erpOrderCancellationMailConfigTransfer->getCancellation()->getCancellationNumber(), $exception->getMessage()), ['exception' => $exception]);
            $response->setIsSuccessful(false);
        }

        return $response;
    }
}
