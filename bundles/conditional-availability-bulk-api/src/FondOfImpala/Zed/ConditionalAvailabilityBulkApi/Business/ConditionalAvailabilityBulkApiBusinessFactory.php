<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business;

use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapper;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApi;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApiInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\ConditionalAvailabilityBulkApiDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\ConditionalAvailabilityBulkApiConfig getConfig()
 */
class ConditionalAvailabilityBulkApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Model\ConditionalAvailabilityBulkApiInterface
     */
    public function createConditionalAvailabilitiesBulkApi(): ConditionalAvailabilityBulkApiInterface
    {
        return new ConditionalAvailabilityBulkApi(
            $this->createConditionalAvailabilityBulkApiMapper(),
            $this->getConditionalAvailabilityFacade(),
            $this->getProductFacade(),
            $this->getApiQueryContainer(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToApiFacadeInterface
     */
    protected function getApiQueryContainer(): ConditionalAvailabilityBulkApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityBulkApiDependencyProvider::FACADE_API,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeInterface
     */
    protected function getConditionalAvailabilityFacade(): ConditionalAvailabilityBulkApiToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityBulkApiDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Dependency\Facade\ConditionalAvailabilityBulkApiToProductFacadeInterface
     */
    protected function getProductFacade(): ConditionalAvailabilityBulkApiToProductFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityBulkApiDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Mapper\ConditionalAvailabilityBulkApiMapperInterface
     */
    protected function createConditionalAvailabilityBulkApiMapper(): ConditionalAvailabilityBulkApiMapperInterface
    {
        return new ConditionalAvailabilityBulkApiMapper();
    }
}
