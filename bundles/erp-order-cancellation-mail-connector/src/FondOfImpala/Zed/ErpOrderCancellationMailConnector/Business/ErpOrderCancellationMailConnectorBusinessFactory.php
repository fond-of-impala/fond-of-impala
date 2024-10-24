<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail\MailHandler;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail\MailHandlerInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorDependencyProvider;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()()
 */
class ErpOrderCancellationMailConnectorBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail\MailHandlerInterface
     */
    public function createMailHandler(): MailHandlerInterface
    {
        return new MailHandler(
            $this->getRepository(),
            $this->getMailFacade(),
            $this->getLocaleFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface
     */
    public function getMailFacade(): ErpOrderCancellationMailConnectorToMailFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationMailConnectorDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface
     */
    public function getLocaleFacade(): ErpOrderCancellationMailConnectorToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationMailConnectorDependencyProvider::FACADE_LOCALE);
    }
}
