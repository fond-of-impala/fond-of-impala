<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\SynchronizationExtension;

use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Orm\Zed\ConditionalAvailabilityPageSearch\Persistence\Map\FosConditionalAvailabilityPeriodPageSearchTableMap;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataBulkRepositoryPluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 */
class ConditionalAvailabilityPeriodSynchronizationDataBulkRepositoryPlugin extends AbstractPlugin implements SynchronizationDataBulkRepositoryPluginInterface
{
    /**
     * @param int $offset
     * @param int $limit
     * @param array $ids
     *
     * @return array
     */
    public function getData(int $offset, int $limit, array $ids = []): array
    {
        $data = [];
        $filterTransfer = $this->createFilterTransfer($offset, $limit);

        $conditionalAvailabilityPeriodPageSearchEntityTransfers = $this->getRepository()
            ->findFilteredConditionalAvailabilityPeriodPageSearchEntities($filterTransfer, $ids);

        foreach ($conditionalAvailabilityPeriodPageSearchEntityTransfers as $conditionalAvailabilityPeriodPageSearchEntityTransfer) {
            $synchronizationDataTransfer = (new SynchronizationDataTransfer())
                ->setData($conditionalAvailabilityPeriodPageSearchEntityTransfer->getData())
                ->setKey($conditionalAvailabilityPeriodPageSearchEntityTransfer->getKey());

            $data[] = $synchronizationDataTransfer;
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\FilterTransfer
     */
    protected function createFilterTransfer(int $offset, int $limit): FilterTransfer
    {
        return (new FilterTransfer())
            ->setOffset($offset)
            ->setLimit($limit)
            ->setOrderBy(FosConditionalAvailabilityPeriodPageSearchTableMap::COL_FK_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return ConditionalAvailabilityPageSearchConstants::CONDITIONAL_AVAILABILITY_PERIOD_RESOURCE_NAME;
    }

    /**
     * @return bool
     */
    public function hasStore(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return ['type' => 'conditional-availability-period'];
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return ConditionalAvailabilityPageSearchConstants::CONDITIONAL_AVAILABILITY_SEARCH_QUEUE;
    }

    /**
     * @return string|null
     */
    public function getSynchronizationQueuePoolName(): ?string
    {
        return $this->getConfig()->getConditionalAvailabilityPeriodSynchronizationPoolName();
    }
}
