<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

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
}
