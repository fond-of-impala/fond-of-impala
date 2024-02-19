<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpander;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilter;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilterInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapper;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapperInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister\OrderBudgetPersister;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister\OrderBudgetPersisterInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor\BulkProcessor;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor\BulkProcessorInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReader;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiRepositoryInterface getRepository()
 */
class OrderBudgetsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Processor\BulkProcessorInterface
     */
    public function createBulkProcessor(): BulkProcessorInterface
    {
        return new BulkProcessor(
            $this->getEventFacade(),
            $this->getRestOrderBudgetsBulkRequestExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface
     */
    public function createRestOrderBudgetsBulkRequestExpander(): RestOrderBudgetsBulkRequestExpanderInterface
    {
        return new RestOrderBudgetsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createOrderBudgetReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilterInterface
     */
    protected function createGroupedIdentifierFilter(): UuidsFilterInterface
    {
        return new UuidsFilter();
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface
     */
    protected function createOrderBudgetReader(): OrderBudgetReaderInterface
    {
        return new OrderBudgetReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Persister\OrderBudgetPersisterInterface
     */
    public function createOrderBudgetPersister(): OrderBudgetPersisterInterface
    {
        return new OrderBudgetPersister(
            $this->createOrderBudgetMapper(),
            $this->getOrderBudgetFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Mapper\OrderBudgetMapperInterface
     */
    protected function createOrderBudgetMapper(): OrderBudgetMapperInterface
    {
        return new OrderBudgetMapper();
    }

    /**
     * @return array<\FondOfImpala\Zed\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestExpanderPluginInterface>
     */
    protected function getRestOrderBudgetsBulkRequestExpanderPlugins(): array
    {
        return $this->getProvidedDependency(
            OrderBudgetsBulkRestApiDependencyProvider::PLUGINS_REST_ORDER_BUDGETS_BULK_REQUEST_EXPANDER,
        );
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToEventFacadeInterface
     */
    protected function getEventFacade(): OrderBudgetsBulkRestApiToEventFacadeInterface
    {
        return $this->getProvidedDependency(
            OrderBudgetsBulkRestApiDependencyProvider::FACADE_EVENT,
        );
    }

    /**
     * @return \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\Facade\OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface
     */
    protected function getOrderBudgetFacade(): OrderBudgetsBulkRestApiToOrderBudgetFacadeInterface
    {
        return $this->getProvidedDependency(
            OrderBudgetsBulkRestApiDependencyProvider::FACADE_ORDER_BUDGET,
        );
    }
}
