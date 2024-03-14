<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Plugin\PriceProductPriceListSearchRestApi;

use Exception;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;
use Throwable;

/**
 * @method \FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiFactory getFactory()
 * @method \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiClientInterface getClient()
 */
abstract class AbstractPriceListToCompanyCurrencyReducerPlugin extends AbstractPlugin implements ReducerPluginInterface
{
    /**
     * @var string
     */
    protected const INDEX = '';

    /**
     * @var string
     */
    protected const INDEX_PRICES = 'prices';

    /**
     * @param array $data
     *
     * @return array
     */
    public function reduce(array $data): array
    {
        $currencyCode = $this->getCurrencyCodeFromCompany($this->getCompanyTransfer());

        if (array_key_exists(static::INDEX, $data)) {
            foreach ($data[static::INDEX] as $index => $priceListData) {
                if (array_key_exists(static::INDEX_PRICES, $priceListData)) {
                    $prices = $priceListData[static::INDEX_PRICES];
                    unset($priceListData[static::INDEX_PRICES]);

                    $newPrices = [];
                    if (array_key_exists($currencyCode, $prices)) {
                        $newPrices = $prices[$currencyCode];
                    }
                    $priceListData[static::INDEX_PRICES][$currencyCode] = $newPrices;
                    $data[static::INDEX][$index] = $priceListData;
                }
            }
        }

        return $data;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getCurrencyCodeFromCompany(CompanyTransfer $companyTransfer): string
    {
        $companyCurrency = (new CurrencyTransfer())->setIdCurrency($companyTransfer->getFkCurrency());
        $companyCurrency = $this->getClient()->getCurrencyById($companyCurrency);
        $currencyCode = $companyCurrency->getCode();

        if ($currencyCode === null) {
            throw new Exception(sprintf('Could not get company currency for company with id "%s"', $companyTransfer->getIdCompany()));
        }

        return $currencyCode;
    }

    /**
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    protected function getCompanyTransfer(): CompanyTransfer
    {
        try {
            $customer = $this->getFactory()->getCustomerClient()->getCustomer();
            $company = $customer->getCompanyUserTransfer()->getCompany();
        } catch (Throwable $throwable) {
            throw new Exception('Could not get company');
        }

        return $company;
    }
}
