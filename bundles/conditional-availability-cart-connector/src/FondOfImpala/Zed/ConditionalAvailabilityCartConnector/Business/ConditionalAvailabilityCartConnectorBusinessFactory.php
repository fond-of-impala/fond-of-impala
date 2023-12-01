<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business;

use DateTime;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpander;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilter;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilter;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinder;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGenerator;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGenerator;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDate;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\CustomerReader;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducer;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface getRepository()
 */
class ConditionalAvailabilityCartConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander(
            $this->createConditionalAvailabilityReader(),
            $this->createItemExpander(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface
     */
    protected function createConditionalAvailabilityReader(): ConditionalAvailabilityReaderInterface
    {
        return new ConditionalAvailabilityReader(
            $this->createSkusFilter(),
            $this->createCustomerReader(),
            $this->getConditionalAvailabilityFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\SkusFilterInterface
     */
    protected function createSkusFilter(): SkusFilterInterface
    {
        return new SkusFilter();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->getCustomerFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface
     */
    public function createConditionalAvailabilityDeliveryDateCleaner(): ConditionalAvailabilityDeliveryDateCleanerInterface
    {
        return new ConditionalAvailabilityDeliveryDateCleaner();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface
     */
    public function createConditionalAvailabilityEnsureEarliestDate(): ConditionalAvailabilityEnsureEarliestDateInterface
    {
        return new ConditionalAvailabilityEnsureEarliestDate();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface
     */
    public function createConditionalAvailabilityItemExpander(): ConditionalAvailabilityItemExpanderInterface
    {
        return new ConditionalAvailabilityItemExpander(
            $this->getService(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface
     */
    protected function createItemExpander(): ItemExpanderInterface
    {
        return new ItemExpander(
            $this->createConditionalAvailabilityPeriodsFilter(),
            $this->createIndexFinder(),
            $this->createMessageGenerator(),
            $this->createDeliveryDateGenerator(),
            $this->createConditionalAvailabilityPeriodsReducer(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface
     */
    protected function createDeliveryDateGenerator(): DeliveryDateGeneratorInterface
    {
        return new DeliveryDateGenerator(
            new DateTime(),
            $this->getConditionalAvailabilityService()->generateEarliestDeliveryDate(),
            $this->getConditionalAvailabilityService(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface
     */
    protected function createMessageGenerator(): MessageGeneratorInterface
    {
        return new MessageGenerator();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface
     */
    protected function createConditionalAvailabilityPeriodsReducer(): ConditionalAvailabilityPeriodsReducerInterface
    {
        return new ConditionalAvailabilityPeriodsReducer();
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface
     */
    protected function createIndexFinder(): IndexFinderInterface
    {
        return new IndexFinder(
            new DateTime(),
            $this->getConditionalAvailabilityService()->generateEarliestDeliveryDate(),
            $this->getConditionalAvailabilityService(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface
     */
    protected function createConditionalAvailabilityPeriodsFilter(): ConditionalAvailabilityPeriodsFilterInterface
    {
        return new ConditionalAvailabilityPeriodsFilter();
    }

    /**
     * @return \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE);
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected function getConditionalAvailabilityService(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
     */
    protected function getConditionalAvailabilityFacade(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CUSTOMER,
        );
    }
}
