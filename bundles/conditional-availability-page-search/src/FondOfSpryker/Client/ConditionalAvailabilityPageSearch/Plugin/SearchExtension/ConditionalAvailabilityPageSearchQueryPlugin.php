<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchAll;
use Elastica\Query\MultiMatch;
use Generated\Shared\Search\ConditionalAvailabilityPeriodIndexMap;
use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextAwareQueryInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchStringGetterInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\SearchStringSetterInterface;

class ConditionalAvailabilityPageSearchQueryPlugin extends AbstractPlugin implements QueryInterface, SearchContextAwareQueryInterface, SearchStringSetterInterface, SearchStringGetterInterface
{
    /**
     * @var string
     */
    protected const SOURCE_IDENTIFIER = 'conditional-availability-period';

    /**
     * @var \Elastica\Query
     */
    protected $query;

    /**
     * @var \Generated\Shared\Transfer\SearchContextTransfer
     */
    protected $searchContextTransfer;

    /**
     * @var string
     */
    protected $searchString = '';

    public function __construct()
    {
        $this->query = $this->createSearchQuery();
    }

    /**
     * @return \Elastica\Query
     */
    protected function createSearchQuery(): Query
    {
        $boolQuery = (new BoolQuery())
            ->addMust($this->createFulltextSearchQuery());

        return (new Query())
            ->setQuery($boolQuery)
            ->setSource([ConditionalAvailabilityPeriodIndexMap::SEARCH_RESULT_DATA]);
    }

    /**
     * @return \Elastica\Query\AbstractQuery
     */
    protected function createFulltextSearchQuery(): AbstractQuery
    {
        if ($this->searchString === '') {
            return new MatchAll();
        }

        return (new MultiMatch())->setFields([ConditionalAvailabilityPeriodIndexMap::SKU, ConditionalAvailabilityPeriodIndexMap::WAREHOUSE_GROUP])
            ->setQuery($this->searchString)
            ->setType(MultiMatch::TYPE_CROSS_FIELDS);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return mixed A query object.
     */
    public function getSearchQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated This method will be moved to `\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface`.
     *
     * @return \Generated\Shared\Transfer\SearchContextTransfer
     */
    public function getSearchContext(): SearchContextTransfer
    {
        if (!$this->hasSearchContext()) {
            $this->setupDefaultSearchContext();
        }

        return $this->searchContextTransfer;
    }

    /**
     * @return bool
     */
    protected function hasSearchContext(): bool
    {
        return (bool)$this->searchContextTransfer;
    }

    /**
     * @return void
     */
    protected function setupDefaultSearchContext(): void
    {
        $searchContextTransfer = new SearchContextTransfer();
        $searchContextTransfer->setSourceIdentifier(static::SOURCE_IDENTIFIER);

        $this->searchContextTransfer = $searchContextTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated This method will be moved to `\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface`.
     *
     * @param \Generated\Shared\Transfer\SearchContextTransfer $searchContextTransfer
     *
     * @return void
     */
    public function setSearchContext(SearchContextTransfer $searchContextTransfer): void
    {
        $this->searchContextTransfer = $searchContextTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $searchString
     *
     * @return void
     */
    public function setSearchString($searchString): void
    {
        $this->searchString = $searchString;
        $this->query = $this->createSearchQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getSearchString(): string
    {
        return $this->searchString;
    }
}
