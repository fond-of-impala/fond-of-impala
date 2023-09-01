<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Mapper;

use Generated\Shared\Transfer\PriceListApiTransfer;

interface TransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\PriceListApiTransfer
     */
    public function toTransfer(array $data): PriceListApiTransfer;

    /**
     * @param array $data
     *
     * @return array<\Generated\Shared\Transfer\PriceListApiTransfer>
     */
    public function toTransferCollection(array $data): array;
}
