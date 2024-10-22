<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\MailTransfer;
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
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacade
     */
    public function __construct(
        ErpOrderCancellationMailConnectorRepositoryInterface $repository,
        ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacade,
        ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacade
    ) {
        $this->repository = $repository;
        $this->mailFacade = $mailFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function sendMail(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer
    {
       try {
           $response = (new ErpOrderCancellationMailConfigResponseTransfer())
               ->setIsSuccessful(false)
               ->setConfig($erpOrderCancellationMailConfigTransfer);

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
        }catch (Throwable $exception) {
            $response->setIsSuccessful(false);
        }

        return $response->setMail($mailTransfer);
    }
}
