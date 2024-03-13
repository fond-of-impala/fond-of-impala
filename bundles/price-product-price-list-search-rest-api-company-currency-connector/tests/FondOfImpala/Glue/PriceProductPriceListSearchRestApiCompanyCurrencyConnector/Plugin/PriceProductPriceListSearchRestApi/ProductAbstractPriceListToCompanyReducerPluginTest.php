<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Plugin\PriceProductPriceListSearchRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductAbstractPriceListToCompanyReducerPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Plugin\PriceProductPriceListSearchRestApi\ProductAbstractPriceListToCompanyCurrencyReducerPlugin
     */
    protected ProductAbstractPriceListToCompanyCurrencyReducerPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductAbstractPriceListToCompanyCurrencyReducerPlugin();
        $this->plugin->setClient($this->clientMock);
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testReduce(): void
    {
        $data = [
            'price_product_abstract_price_lists' => [
                0 => [
                    'prices' => [
                        'EUR' => [],
                        'GEK' => [],
                        'USD' => [],
                    ],
                ],
            ],
        ];

        $dataComp = [
            'price_product_abstract_price_lists' => [
                0 => [
                    'prices' => [
                        'EUR' => [],
                    ],
                ],
            ],
        ];

        $this->factoryMock
            ->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock
            ->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCurrency')
            ->willReturn(46);

        $this->clientMock
            ->expects(static::atLeastOnce())
            ->method('getCurrencyById')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCode')
            ->willReturn('EUR');

        $this->assertEquals($this->plugin->reduce($data), $dataComp);
    }
}
