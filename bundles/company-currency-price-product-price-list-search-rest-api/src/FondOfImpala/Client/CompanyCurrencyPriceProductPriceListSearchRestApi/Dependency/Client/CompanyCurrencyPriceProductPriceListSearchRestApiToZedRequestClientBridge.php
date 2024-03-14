<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client;

use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientBridge implements CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface
{
    protected ZedRequestClientInterface $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call(string $url, TransferInterface $object, ?array $requestOptions = null): TransferInterface
    {
        return $this->zedRequestClient->call($url, $object, $requestOptions);
    }
}
