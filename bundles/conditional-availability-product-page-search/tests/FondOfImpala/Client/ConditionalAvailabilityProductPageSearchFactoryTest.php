<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use Codeception\Test\Unit;
use Spryker\Client\SearchElasticsearch\Query\QueryBuilderInterface;

class ConditionalAvailabilityProductPageSearchFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory
     */
    protected ConditionalAvailabilityProductPageSearchFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factory = new ConditionalAvailabilityProductPageSearchFactory();
    }

    /**
     * @return void
     */
    public function testCreateQueryBuilder(): void
    {
        static::assertInstanceOf(
            QueryBuilderInterface::class,
            $this->factory->createQueryBuilder(),
        );
    }
}
