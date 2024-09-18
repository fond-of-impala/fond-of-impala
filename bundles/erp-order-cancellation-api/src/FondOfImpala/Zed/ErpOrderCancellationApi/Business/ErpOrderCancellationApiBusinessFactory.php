<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business;

use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApi;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApiInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidator;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiConfig getConfig()
 */
class ErpOrderCancellationApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApiInterface
     */
    public function createErpOrderCancellationApi(): ErpOrderCancellationApiInterface
    {
        return new ErpOrderCancellationApi(
            $this->getApiFacade(),
            $this->getErpOrderCancellationFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface
     */
    protected function getApiFacade(): ErpOrderCancellationApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationApiDependencyProvider::FACADE_API);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
     */
    protected function getErpOrderCancellationFacade(): ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface
     */
    public function createErpOrderCancellationApiValidator(): ErpOrderCancellationApiValidatorInterface
    {
        return new ErpOrderCancellationApiValidator();
    }
}
