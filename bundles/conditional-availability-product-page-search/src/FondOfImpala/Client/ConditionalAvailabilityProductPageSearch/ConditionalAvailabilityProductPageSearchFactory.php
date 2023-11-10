<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilder;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface;

class ConditionalAvailabilityProductPageSearchFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface
     */
    public function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder();
    }

    /**
     * @return \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): ConditionalAvailabilityProductPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::CLIENT_CUSTOMER);
    }
}
