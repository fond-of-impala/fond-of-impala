<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\IdConditionalAvailabilityFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\KeyFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityPeriodPageSearchPublisher implements ConditionalAvailabilityPeriodPageSearchPublisherInterface
{
    protected KeyFilterInterface $keyFilter;

    protected ConditionalAvailabilityPeriodPageSearchDataMapperInterface $conditionalAvailabilityPeriodPageSearchDataMapper;

    protected ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpander;

    protected ConditionalAvailabilityPageSearchQueryContainerInterface $queryContainer;

    protected ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager;

    protected ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingService;

    protected IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\KeyFilterInterface $keyFilter
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Filter\IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpander
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchDataMapperInterface $conditionalAvailabilityPeriodPageSearchDataMapper
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface $queryContainer
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        KeyFilterInterface $keyFilter,
        IdConditionalAvailabilityFilterInterface $idConditionalAvailabilityFilter,
        ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpander,
        ConditionalAvailabilityPeriodPageSearchDataMapperInterface $conditionalAvailabilityPeriodPageSearchDataMapper,
        ConditionalAvailabilityPageSearchQueryContainerInterface $queryContainer,
        ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager,
        ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->keyFilter = $keyFilter;
        $this->idConditionalAvailabilityFilter = $idConditionalAvailabilityFilter;
        $this->conditionalAvailabilityPeriodPageSearchExpander = $conditionalAvailabilityPeriodPageSearchExpander;
        $this->conditionalAvailabilityPeriodPageSearchDataMapper = $conditionalAvailabilityPeriodPageSearchDataMapper;
        $this->queryContainer = $queryContainer;
        $this->entityManager = $entityManager;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param string $eventName
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function publish(string $eventName, array $eventEntityTransfers): void
    {
        if ($eventName !== ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_PUBLISH) {
            $keys = $this->keyFilter->filterFromEventEntities($eventEntityTransfers);

            $this->publishByKeys($keys);

            return;
        }

        $conditionalAvailabilityIds = $this->idConditionalAvailabilityFilter->filterFromEventEntities(
            $eventEntityTransfers,
        );

        $this->publishByConditionalAvailabilityIds($conditionalAvailabilityIds);
    }

    /**
     * @param array<string> $keys
     *
     * @return void
     */
    public function publishByKeys(array $keys): void
    {
        $foiConditionalAvailabilityPeriodEntities = $this->queryContainer
            ->queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByKeys($keys)
            ->find()
            ->getData();

        $this->storeData($foiConditionalAvailabilityPeriodEntities);
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publishByConditionalAvailabilityIds(array $conditionalAvailabilityIds): void
    {
        $foiConditionalAvailabilityPeriodEntities = $this->queryContainer
            ->queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
                $conditionalAvailabilityIds,
            )->find()
            ->getData();

        $this->storeData($foiConditionalAvailabilityPeriodEntities);
    }

    /**
     * @param array<\Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod> $foiConditionalAvailabilityPeriodEntities
     *
     * @return void
     */
    protected function storeData(array $foiConditionalAvailabilityPeriodEntities): void
    {
        foreach ($foiConditionalAvailabilityPeriodEntities as $foiConditionalAvailabilityPeriodEntity) {
            $this->storeDataSet($foiConditionalAvailabilityPeriodEntity);
        }
    }

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriodEntity
     *
     * @return void
     */
    protected function storeDataSet(FoiConditionalAvailabilityPeriod $foiConditionalAvailabilityPeriodEntity): void
    {
        $conditionalAvailabilityPeriodData = $foiConditionalAvailabilityPeriodEntity->toArray();

        $conditionalAvailabilityPeriodPageSearchTransfer = (new ConditionalAvailabilityPeriodPageSearchTransfer())
            ->fromArray($conditionalAvailabilityPeriodData, true)
            ->setData($conditionalAvailabilityPeriodData);

        $conditionalAvailabilityPeriodPageSearchTransfer = $this->conditionalAvailabilityPeriodPageSearchExpander
            ->expand($conditionalAvailabilityPeriodPageSearchTransfer);

         $conditionalAvailabilityPeriodPageSearchTransfer = $this->addDataAttributes(
             $conditionalAvailabilityPeriodPageSearchTransfer,
         );

        $this->entityManager->persistConditionalAvailabilityPeriodPageSearch(
            $conditionalAvailabilityPeriodPageSearchTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer
     */
    protected function addDataAttributes(
        ConditionalAvailabilityPeriodPageSearchTransfer $conditionalAvailabilityPeriodPageSearchTransfer
    ): ConditionalAvailabilityPeriodPageSearchTransfer {
        $data = array_merge(
            $conditionalAvailabilityPeriodPageSearchTransfer->toArray(),
            $conditionalAvailabilityPeriodPageSearchTransfer->getData(),
        );

        $data = $this->conditionalAvailabilityPeriodPageSearchDataMapper
            ->mapConditionalAvailabilityPeriodDataToSearchData($data);

        $structuredData = $this->utilEncodingService->encodeJson($data);

        return $conditionalAvailabilityPeriodPageSearchTransfer->setData($data)
            ->setStructuredData($structuredData);
    }
}
