<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesChecker;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouper;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapper;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapperInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReader;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorRepositoryInterface getRepository()
 */
class ConditionalAvailabilityCheckoutConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Checker\AvailabilitiesCheckerInterface
     */
    public function createAvailabilitiesChecker(): AvailabilitiesCheckerInterface
    {
        return new AvailabilitiesChecker(
            $this->createItemsGrouper(),
            $this->createConditionalAvailabilityCriteriaFilterMapper(),
            $this->getConditionalAvailabilityFacade(),
            $this->getConditionalAvailabilityService(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Grouper\ItemsGrouperInterface
     */
    protected function createItemsGrouper(): ItemsGrouperInterface
    {
        return new ItemsGrouper();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper\ConditionalAvailabilityCriteriaFilterMapperInterface
     */
    protected function createConditionalAvailabilityCriteriaFilterMapper(): ConditionalAvailabilityCriteriaFilterMapperInterface
    {
        return new ConditionalAvailabilityCriteriaFilterMapper(
            $this->createCustomerReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->getCustomerFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface
     */
    protected function getConditionalAvailabilityFacade(): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCheckoutConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service\ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface
     */
    protected function getConditionalAvailabilityService(): ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCheckoutConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCheckoutConnectorDependencyProvider::FACADE_CUSTOMER,
        );
    }
}
