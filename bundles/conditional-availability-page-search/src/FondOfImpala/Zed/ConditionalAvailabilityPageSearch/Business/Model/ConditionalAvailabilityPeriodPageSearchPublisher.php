<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodPageSearchTransfer;
use Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod;

class ConditionalAvailabilityPeriodPageSearchPublisher implements ConditionalAvailabilityPeriodPageSearchPublisherInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface
     */
    protected $conditionalAvailabilityPeriodPageSearchExpander;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchDataMapperInterface
     */
    protected $conditionalAvailabilityPeriodPageSearchDataMapper;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface $queryContainer
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpander
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingService
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchDataMapperInterface $conditionalAvailabilityPeriodPageSearchDataMapper
     */
    public function __construct(
        ConditionalAvailabilityPageSearchQueryContainerInterface $queryContainer,
        ConditionalAvailabilityPageSearchEntityManagerInterface $entityManager,
        ConditionalAvailabilityPeriodPageSearchExpanderInterface $conditionalAvailabilityPeriodPageSearchExpander,
        ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface $utilEncodingService,
        ConditionalAvailabilityPeriodPageSearchDataMapperInterface $conditionalAvailabilityPeriodPageSearchDataMapper
    ) {
        $this->queryContainer = $queryContainer;
        $this->entityManager = $entityManager;
        $this->conditionalAvailabilityPeriodPageSearchExpander = $conditionalAvailabilityPeriodPageSearchExpander;
        $this->utilEncodingService = $utilEncodingService;
        $this->conditionalAvailabilityPeriodPageSearchDataMapper = $conditionalAvailabilityPeriodPageSearchDataMapper;
    }

    /**
     * @param array<int> $conditionalAvailabilityIds
     *
     * @return void
     */
    public function publish(array $conditionalAvailabilityIds): void
    {
        $FoiConditionalAvailabilityPeriodEntities = $this->queryContainer
            ->queryConditionalAvailabilityPeriodsWithConditionalAvailabilityAndProductByConditionalAvailabilityIds(
                $conditionalAvailabilityIds,
            )->find()
            ->getData();

        if (count($FoiConditionalAvailabilityPeriodEntities) > 0) {
            $this->entityManager->deleteConditionalAvailabilityPeriodSearchPagesByConditionalAvailabilityIds(
                $conditionalAvailabilityIds,
            );
        }

        $this->storeData($FoiConditionalAvailabilityPeriodEntities);
    }

    /**
     * @param array<\Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod> $FoiConditionalAvailabilityPeriodEntities
     *
     * @return void
     */
    protected function storeData(array $FoiConditionalAvailabilityPeriodEntities): void
    {
        foreach ($FoiConditionalAvailabilityPeriodEntities as $FoiConditionalAvailabilityPeriodEntity) {
            $this->storeDataSet($FoiConditionalAvailabilityPeriodEntity);
        }
    }

    /**
     * @param \Orm\Zed\ConditionalAvailability\Persistence\Base\FoiConditionalAvailabilityPeriod $FoiConditionalAvailabilityPeriodEntity
     *
     * @return void
     */
    protected function storeDataSet(FoiConditionalAvailabilityPeriod $FoiConditionalAvailabilityPeriodEntity): void
    {
        $conditionalAvailabilityPeriodData = $FoiConditionalAvailabilityPeriodEntity->toArray();

        $conditionalAvailabilityPeriodPageSearchTransfer = (new ConditionalAvailabilityPeriodPageSearchTransfer())
            ->fromArray($conditionalAvailabilityPeriodData, true)
            ->setData($conditionalAvailabilityPeriodData);

        $conditionalAvailabilityPeriodPageSearchTransfer = $this->conditionalAvailabilityPeriodPageSearchExpander
            ->expand($conditionalAvailabilityPeriodPageSearchTransfer);

         $conditionalAvailabilityPeriodPageSearchTransfer = $this->addDataAttributes(
             $conditionalAvailabilityPeriodPageSearchTransfer,
         );

        $this->entityManager->createConditionalAvailabilityPeriodPageSearch(
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
