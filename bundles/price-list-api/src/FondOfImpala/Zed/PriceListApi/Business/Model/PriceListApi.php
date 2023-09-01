<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Model;

use FondOfImpala\Zed\PriceListApi\Business\Exception\MissingPriceDimensionException;
use FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapperInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface;
use FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiPaginationTransfer;
use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\PriceListApiTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnTransfer;
use Orm\Zed\PriceList\Persistence\Map\FoiPriceListTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Map\TableMap;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class PriceListApi implements PriceListApiInterface
{
    use LoggerTrait;

    protected PriceListApiToPriceListFacadeInterface $priceListFacade;

    protected TransferMapperInterface $transferMapper;

    protected PriceListApiToPriceProductPriceListFacadeInterface $priceProductPriceListFacade;

    /**
     * @var array<\FondOfImpala\Zed\PriceListApi\Dependency\Plugin\PriceProductsHydrationPluginInterface>
     */
    protected array $priceProductsHydrationPlugins;

    protected ConnectionInterface $connection;

    protected PriceListApiToApiFacadeInterface $apiFacade;

    protected PriceListApiQueryContainerInterface $queryContainer;

    protected PriceListApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer;

    /**
     * @param \Propel\Runtime\Connection\ConnectionInterface $connection
     * @param \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface $priceListFacade
     * @param \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface $priceProductPriceListFacade
     * @param \FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapperInterface $transferMapper
     * @param \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface $apiFacade
     * @param \FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer
     * @param \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface $queryContainer
     * @param array<\FondOfImpala\Zed\PriceListApi\Dependency\Plugin\PriceProductsHydrationPluginInterface> $priceProductsHydrationPlugins
     */
    public function __construct(
        ConnectionInterface $connection,
        PriceListApiToPriceListFacadeInterface $priceListFacade,
        PriceListApiToPriceProductPriceListFacadeInterface $priceProductPriceListFacade,
        TransferMapperInterface $transferMapper,
        PriceListApiToApiFacadeInterface $apiFacade,
        PriceListApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer,
        PriceListApiQueryContainerInterface $queryContainer,
        array $priceProductsHydrationPlugins
    ) {
        $this->connection = $connection;
        $this->priceListFacade = $priceListFacade;
        $this->priceProductPriceListFacade = $priceProductPriceListFacade;
        $this->transferMapper = $transferMapper;
        $this->apiFacade = $apiFacade;
        $this->priceProductsHydrationPlugins = $priceProductsHydrationPlugins;
        $this->queryContainer = $queryContainer;
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $data = (array)$apiDataTransfer->getData();
        $priceListApiTransfer = $this->transferMapper->toTransfer($data);

        $priceListTransfer = new PriceListTransfer();
        $priceListTransfer->fromArray($priceListApiTransfer->toArray(), true);

        $priceListTransfer = $this->addPriceList($priceListTransfer);

        return $this->persistPriceListEntries($priceListTransfer, $priceListApiTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    protected function addPriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        $this->connection->beginTransaction();

        try {
            $priceListTransfer = $this->priceListFacade->createPriceList($priceListTransfer);
        } catch (Throwable $throwable) {
            $this->connection->rollBack();

            throw new EntityNotSavedException(sprintf('Could not save price list: %s', $throwable->getMessage()), ApiConfig::HTTP_CODE_INTERNAL_ERROR);
        }

        $this->connection->commit();

        return $priceListTransfer;
    }

    /**
     * @param int $id
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update(int $id, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $priceListTransfer = $this->getByIdPriceList($id);

        if ($priceListTransfer === null) {
            throw new EntityNotFoundException(sprintf('price list not found: %s', $id));
        }

        $data = (array)$apiDataTransfer->getData();
        $priceListApiTransfer = $this->transferMapper->toTransfer($data);

        $priceListTransfer->fromArray($priceListApiTransfer->toArray(), true)
            ->setIdPriceList($id);

        $priceListTransfer = $this->updatePriceList($priceListTransfer);

        return $this->persistPriceListEntries($priceListTransfer, $priceListApiTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    protected function updatePriceList(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        $this->connection->beginTransaction();

        try {
            $priceListTransfer = $this->priceListFacade->updatePriceList($priceListTransfer);
        } catch (Throwable $throwable) {
            $this->connection->rollBack();

            throw new EntityNotSavedException(sprintf('Could not save price list: %s', $throwable->getMessage()), ApiConfig::HTTP_CODE_INTERNAL_ERROR);
        }

        $this->connection->commit();

        return $priceListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     * @param \Generated\Shared\Transfer\PriceListApiTransfer $priceListApiTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotSavedException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    protected function persistPriceListEntries(
        PriceListTransfer $priceListTransfer,
        PriceListApiTransfer $priceListApiTransfer
    ): ApiItemTransfer {
        $this->connection->beginTransaction();

        $priceProductTransfers = $priceListApiTransfer->getPriceListEntries()->getArrayCopy();

        foreach ($this->priceProductsHydrationPlugins as $priceProductsHydrationPlugin) {
            $priceProductTransfers = $priceProductsHydrationPlugin->hydrate($priceProductTransfers);
        }

        foreach ($priceProductTransfers as $priceProductTransfer) {
            try {
                $this->persistPriceProduct($priceListTransfer, $priceProductTransfer);
            } catch (Throwable $throwable) {
                $this->connection->rollBack();

                throw new EntityNotSavedException(sprintf('Could not save price list entries: %s', $throwable->getMessage()), ApiConfig::HTTP_CODE_INTERNAL_ERROR);
            }
        }

        $this->connection->commit();

        return $this->apiFacade->createApiItem($priceListApiTransfer, (string)$priceListTransfer->getIdPriceList());
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @throws \FondOfImpala\Zed\PriceListApi\Business\Exception\MissingPriceDimensionException
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    protected function persistPriceProduct(
        PriceListTransfer $priceListTransfer,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductTransfer {
        if ($priceProductTransfer->getPriceDimension() === null) {
            throw new MissingPriceDimensionException('Price dimension is missing.', ApiConfig::HTTP_CODE_INTERNAL_ERROR);
        }

        if ($priceProductTransfer->getIdProductAbstract() === null && $priceProductTransfer->getIdProduct() === null) {
            return $priceProductTransfer;
        }

        $priceProductTransfer->getPriceDimension()->setIdPriceList($priceListTransfer->getIdPriceList());

        $this->priceProductPriceListFacade->savePriceProductPriceList($priceProductTransfer);

        return $priceProductTransfer;
    }

    /**
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    protected function getByIdPriceList(int $idPriceList): ?PriceListTransfer
    {
        $priceListTransfer = new PriceListTransfer();
        $priceListTransfer->setIdPriceList($idPriceList);

        return $this->priceListFacade->findPriceListById($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $query = $this->buildQuery($apiRequestTransfer);
        $collection = $this->transferMapper->toTransferCollection($query->find()->toArray());

        foreach ($collection as $k => $priceListApiTransfer) {
            $collection[$k] = $this->getByIdPriceList($priceListApiTransfer->getIdPriceList());
        }

        $apiCollectionTransfer = $this->apiFacade->createApiCollection($collection);
        $apiCollectionTransfer = $this->addPagination($query, $apiCollectionTransfer, $apiRequestTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function buildQuery(ApiRequestTransfer $apiRequestTransfer): ModelCriteria
    {
        $apiQueryBuilderQueryTransfer = $this->buildApiQueryBuilderQuery($apiRequestTransfer);
        $query = $this->queryContainer->queryFind();
        $query = $this->apiQueryBuilderQueryContainer->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);

        return $query;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer
     */
    protected function buildApiQueryBuilderQuery(ApiRequestTransfer $apiRequestTransfer): ApiQueryBuilderQueryTransfer
    {
        $columnSelectionTransfer = $this->buildColumnSelection();
        $apiQueryBuilderQueryTransfer = (new ApiQueryBuilderQueryTransfer())
            ->setApiRequest($apiRequestTransfer)
            ->setColumnSelection($columnSelectionTransfer);

        return $apiQueryBuilderQueryTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer
     */
    protected function buildColumnSelection(): PropelQueryBuilderColumnSelectionTransfer
    {
        $columnSelectionTransfer = new PropelQueryBuilderColumnSelectionTransfer();
        $tableColumns = FoiPriceListTableMap::getFieldNames(TableMap::TYPE_FIELDNAME);
        foreach ($tableColumns as $columnAlias) {
            $columnTransfer = (new PropelQueryBuilderColumnTransfer())
                ->setName(FoiPriceListTableMap::TABLE_NAME . '.' . $columnAlias)
                ->setAlias($columnAlias);
            $columnSelectionTransfer->addTableColumn($columnTransfer);
        }

        return $columnSelectionTransfer;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiCollectionTransfer $apiCollectionTransfer
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected function addPagination(
        ModelCriteria $query,
        ApiCollectionTransfer $apiCollectionTransfer,
        ApiRequestTransfer $apiRequestTransfer
    ): ApiCollectionTransfer {
        $query->setOffset(0)
            ->setLimit(-1);
        $total = $query->count();
        $page = $apiRequestTransfer->getFilter()->getLimit() ? ($apiRequestTransfer->getFilter()->getOffset() / $apiRequestTransfer->getFilter()->getLimit() + 1) : 1;
        $pageTotal = ($total && $apiRequestTransfer->getFilter()->getLimit()) ? (int)ceil($total / $apiRequestTransfer->getFilter()->getLimit()) : 1;
        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, ApiConfig::HTTP_CODE_NOT_FOUND);
        }
        $apiPaginationTransfer = (new ApiPaginationTransfer())
            ->setItemsPerPage($apiRequestTransfer->getFilter()->getLimit())
            ->setPage($page)
            ->setTotal($total)
            ->setPageTotal($pageTotal);
        $apiCollectionTransfer->setPagination($apiPaginationTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @param int $idPriceList
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get(int $idPriceList): ApiItemTransfer
    {
        $priceListTransfer = $this->getByIdPriceList($idPriceList);

        if ($priceListTransfer === null) {
            throw new EntityNotFoundException(sprintf('Price list not found for id %s', $idPriceList));
        }

        return $this->apiFacade->createApiItem($priceListTransfer, (string)$idPriceList);
    }
}
