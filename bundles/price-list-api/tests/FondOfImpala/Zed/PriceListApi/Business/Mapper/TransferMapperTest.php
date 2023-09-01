<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceListApiTransfer;

class TransferMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapper
     */
    protected TransferMapper $transferMapper;

    private ?array $transferData = null;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->transferData = [['name' => 'Lorem Ipsum']];

        $this->transferMapper = new TransferMapper();
    }

    /**
     * @return void
     */
    public function testToTransfer(): void
    {
        $priceListApiTransfer = $this->transferMapper->toTransfer($this->transferData[0]);
        static::assertInstanceOf(PriceListApiTransfer::class, $priceListApiTransfer);
        static::assertEquals('Lorem Ipsum', $priceListApiTransfer->getName());
    }

    /**
     * @return void
     */
    public function testToTransferCollection(): void
    {
        static::assertIsArray($this->transferMapper->toTransferCollection($this->transferData));
        static::assertEquals('Lorem Ipsum', $this->transferMapper->toTransferCollection($this->transferData)[0]->getName());
    }
}
