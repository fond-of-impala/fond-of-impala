<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model;

use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\Map\FoiErpOrderCancellationTableMap;
use PHPUnit\Util\Exception;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;
use Throwable;

class ErpOrderCancellationApi implements ErpOrderCancellationApiInterface
{
    /**
     * @var string
     */
    protected const KEY_ID_ERP_ORDER_CANCELLATION = 'id_erp_order_cancellation';

    /**
     * @var string
     */
    protected const KEY_RULES = 'rules';

    /**
     * @var string
     */
    protected const KEY_STATE = 'state';

    /**
     * @var string
     */
    protected const KEY_FIELD = 'field';

    /**
     * @var string
     */
    protected const KEY_VALUE = 'value';

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface
     */
    protected $apiFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
     */
    protected $erpOrderCancellationFacade;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface $apiFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade
     * @param \FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface $repository
     */
    public function __construct(
        ErpOrderCancellationApiToApiFacadeInterface $apiFacade,
        ErpOrderCancellationApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacade,
        ErpOrderCancellationApiRepositoryInterface $repository
    ) {
        $this->apiFacade = $apiFacade;
        $this->erpOrderCancellationFacade = $erpOrderCancellationFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function create(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $erpOrderCancellationTransfer = (new ErpOrderCancellationTransfer())->fromArray($apiDataTransfer->getData(), true);
        $erpOrderCancellationResponseTransfer = $this->erpOrderCancellationFacade->createErpOrderCancellation($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $erpOrderCancellationResponseTransfer->getErpOrderCancellation();

        if ($erpOrderCancellationTransfer === null || !$erpOrderCancellationResponseTransfer->getIsSuccessful()) {
            throw new EntityNotSavedException(
                sprintf('Could not create erp order cancellation.'),
                ApiConfig::HTTP_CODE_INTERNAL_ERROR,
            );
        }

        return $this->apiFacade->createApiItem(
            $erpOrderCancellationTransfer,
            (string)$erpOrderCancellationTransfer->getIdErpOrderCancellation(),
        );
    }

    /**
     * @param int $idErpOrderCancellation
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update(int $idErpOrderCancellation, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $this->getByIdErpOrderCancellation($idErpOrderCancellation);

        $erpOrderCancellationTransfer = (new ErpOrderCancellationTransfer())
            ->fromArray($apiDataTransfer->getData(), true)
            ->setIdErpOrderCancellation($idErpOrderCancellation);

        $erpOrderCancellationResponseTransfer = $this->erpOrderCancellationFacade->updateErpOrderCancellation($erpOrderCancellationTransfer);
        $erpOrderCancellationTransfer = $erpOrderCancellationResponseTransfer->getErpOrderCancellation();

        if ($erpOrderCancellationTransfer === null || !$erpOrderCancellationResponseTransfer->getIsSuccessful()) {
            throw new EntityNotSavedException(
                sprintf('Could not update erp order cancellation.'),
                ApiConfig::HTTP_CODE_INTERNAL_ERROR,
            );
        }

        return $this->apiFacade->createApiItem(
            $erpOrderCancellationTransfer,
            (string)$erpOrderCancellationTransfer->getIdErpOrderCancellation(),
        );
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get(int $idErpOrderCancellation): ApiItemTransfer
    {
        $erpOrderCancellationTransfer = $this->getByIdErpOrderCancellation($idErpOrderCancellation);

        return $this->apiFacade->createApiItem($erpOrderCancellationTransfer, (string)$idErpOrderCancellation);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $data = [];
        $apiCollectionTransfer = $this->repository->find($this->resolveStateFilter($apiRequestTransfer));

        foreach ($apiCollectionTransfer->getData() as $index => $item) {
            if (!isset($item[static::KEY_ID_ERP_ORDER_CANCELLATION])) {
                continue;
            }

            $data[$index] = $this->getByIdErpOrderCancellation($item[static::KEY_ID_ERP_ORDER_CANCELLATION])->toArray();
        }

        return $apiCollectionTransfer->setData($data);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function delete(int $idErpOrderCancellation): ApiItemTransfer
    {
        $this->getByIdErpOrderCancellation($idErpOrderCancellation);

        $this->erpOrderCancellationFacade->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);

        return $this->apiFacade->createApiItem(null, (string)$idErpOrderCancellation);
    }

    /**
     * @param int $idErpOrderCancellation
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected function getByIdErpOrderCancellation(int $idErpOrderCancellation): ErpOrderCancellationTransfer
    {
        $erpOrderCancellationTransfer = $this->erpOrderCancellationFacade->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);

        if ($erpOrderCancellationTransfer === null) {
            throw new EntityNotFoundException(
                sprintf('Could not find erp order cancellation.'),
                ApiConfig::HTTP_CODE_NOT_FOUND,
            );
        }

        return $erpOrderCancellationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected function resolveStateFilter(ApiRequestTransfer $apiRequestTransfer): ApiRequestTransfer
    {
        $filter = $apiRequestTransfer->getFilter();

        if ($filter === null || $filter->getCriteriaJson() === null) {
            return $apiRequestTransfer;
        }

        try {
            $jsonData = json_decode($filter->getCriteriaJson(), true);
        } catch (Throwable $exception) {
            return $apiRequestTransfer;
        }

        if (array_key_exists(static::KEY_RULES, $jsonData) === false || !is_array($jsonData[static::KEY_RULES])) {
            return $apiRequestTransfer;
        }

        foreach ($jsonData[static::KEY_RULES] as &$rule) {
            if (array_key_exists(static::KEY_FIELD, $rule) && $rule[static::KEY_FIELD] === static::KEY_STATE) {
                $rule[static::KEY_VALUE] = $this->resolveStateValue($rule[static::KEY_VALUE]);
            }
        }
        unset($rule);

        $filter->setCriteriaJson(json_encode($jsonData));

        return $apiRequestTransfer->setFilter($filter);
    }

    /**
     * @param string $state
     *
     * @throws \PHPUnit\Util\Exception
     *
     * @return int
     */
    protected function resolveStateValue(string $state): int
    {
        $availableStates = array_flip(FoiErpOrderCancellationTableMap::getValueSet(FoiErpOrderCancellationTableMap::COL_STATE));
        if (array_key_exists($state, $availableStates)) {
            return $availableStates[$state];
        }

        throw new Exception(sprintf('State "%s" not found', $state));
    }
}
