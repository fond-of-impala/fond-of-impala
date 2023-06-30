<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchStringSetterInterface;

class ConditionalAvailabilityPageSearchFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): ConditionalAvailabilityPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface
     */
    public function getSearchClient(): ConditionalAvailabilityPageSearchToSearchClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @param string $searchString
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function createSearchQuery(string $searchString): QueryInterface
    {
        $searchQuery = $this->getSearchQueryPlugin();

        if ($searchQuery instanceof SearchStringSetterInterface) {
            $searchQuery->setSearchString($searchString);
        }

        return $searchQuery;
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected function getSearchQueryPlugin(): QueryInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityPageSearchDependencyProvider::PLUGIN_SEARCH_QUERY,
        );
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    public function getSearchQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_QUERY_EXPANDER,
        );
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getSearchResultFormatterPlugins(): array
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_RESULT_FORMATTER,
        );
    }
}
