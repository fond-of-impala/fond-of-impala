<?php

namespace FondOfImpala\Zed\PriceListGui\Communication\Table;

use FondOfImpala\Zed\PriceListGui\Dependency\Service\PriceListGuiToUtilDateTimeServiceInterface;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery;
use Orm\Zed\PriceList\Persistence\Map\FoiPriceListTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class PriceListTable extends AbstractTable
{
    /**
     * @var string
     */
    public const ACTIONS = 'Actions';

    /**
     * @var string
     */
    public const URL_PARAMETER_ID_PRICE_LIST = 'id-price-list';

    /**
     * @var string
     */
    public const URL_UPDATE_PRICE_LIST = '/price-list-gui/price-list/update';

    /**
     * @var string
     */
    public const URL_DELETE_PRICE_LIST = '/price-list-gui/price-list/delete';

    protected PriceListGuiToUtilDateTimeServiceInterface $utilDateTimeService;

    protected FoiPriceListQuery $foiPriceListQuery;

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceListQuery $foiPriceListQuery
     * @param \FondOfImpala\Zed\PriceListGui\Dependency\Service\PriceListGuiToUtilDateTimeServiceInterface $utilDateTimeService
     */
    public function __construct(
        FoiPriceListQuery $foiPriceListQuery,
        PriceListGuiToUtilDateTimeServiceInterface $utilDateTimeService
    ) {
        $this->foiPriceListQuery = $foiPriceListQuery;
        $this->utilDateTimeService = $utilDateTimeService;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            FoiPriceListTableMap::COL_ID_PRICE_LIST => '#',
            FoiPriceListTableMap::COL_NAME => 'Name',
            FoiPriceListTableMap::COL_CREATED_AT => 'Created At',
            FoiPriceListTableMap::COL_UPDATED_AT => 'Updated At',
            static::ACTIONS => static::ACTIONS,
        ]);

        $config->addRawColumn(static::ACTIONS);

        $config->setSortable([
            FoiPriceListTableMap::COL_UPDATED_AT,
            FoiPriceListTableMap::COL_CREATED_AT,
            FoiPriceListTableMap::COL_NAME,
        ]);

        $config->setSearchable([
            FoiPriceListTableMap::COL_NAME,
        ]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $results = [];
        $query = $this->foiPriceListQuery;
        $queryResults = $this->runQuery($query, $config);

        foreach ($queryResults as $queryResult) {
            $results[] = [
                FoiPriceListTableMap::COL_ID_PRICE_LIST => $queryResult[FoiPriceListTableMap::COL_ID_PRICE_LIST],
                FoiPriceListTableMap::COL_NAME => $queryResult[FoiPriceListTableMap::COL_NAME],
                FoiPriceListTableMap::COL_CREATED_AT => $this->utilDateTimeService->formatDateTime(
                    $queryResult[FoiPriceListTableMap::COL_CREATED_AT],
                ),
                FoiPriceListTableMap::COL_UPDATED_AT => $this->utilDateTimeService->formatDateTime(
                    $queryResult[FoiPriceListTableMap::COL_UPDATED_AT],
                ),
                self::ACTIONS => implode(' ', $this->createTableActions($queryResult)),
            ];
        }

        return $results;
    }

    /**
     * @param array $queryResult
     *
     * @return array
     */
    protected function createTableActions(array $queryResult): array
    {
        $buttons = [];

        $buttons[] = $this->generateEditButton(
            Url::generate(static::URL_UPDATE_PRICE_LIST, [
                static::URL_PARAMETER_ID_PRICE_LIST => $queryResult[FoiPriceListTableMap::COL_ID_PRICE_LIST],
            ]),
            'Edit',
        );

        $buttons[] = $this->generateRemoveButton(
            Url::generate(static::URL_DELETE_PRICE_LIST, [
                static::URL_PARAMETER_ID_PRICE_LIST => $queryResult[FoiPriceListTableMap::COL_ID_PRICE_LIST],
            ]),
            'Delete',
        );

        return $buttons;
    }
}
