<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event;

use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use Orm\Zed\ConditionalAvailability\Persistence\Map\FosConditionalAvailabilityTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\EventBehavior\Dependency\Plugin\EventResourceQueryContainerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 */
class ConditionalAvailabilityEventResourceQueryContainerPlugin extends AbstractPlugin implements EventResourceQueryContainerPluginInterface
{
    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return ConditionalAvailabilityPageSearchConstants::CONDITIONAL_AVAILABILITY_PERIOD_RESOURCE_NAME;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PUBLISH;
    }

    /**
     * @return string|null
     */
    public function getIdColumnName(): ?string
    {
        return FosConditionalAvailabilityTableMap::COL_ID_CONDITIONAL_AVAILABILITY;
    }

    /**
     * @param array<int> $ids
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria|null
     */
    public function queryData(array $ids = []): ?ModelCriteria
    {
        return $this->getQueryContainer()->queryConditionalAvailabilitiesByConditionalAvailabilityIds($ids);
    }
}
