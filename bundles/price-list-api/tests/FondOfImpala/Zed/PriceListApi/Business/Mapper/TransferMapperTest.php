<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceListApiTransfer;

class TransferMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapper
     */
    protected $transferMapper;

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
        $this->assertInstanceOf(PriceListApiTransfer::class, $priceListApiTransfer);
        $this->assertEquals('Lorem Ipsum', $priceListApiTransfer->getName());
    }

    /**
     * @return void
     */
    public function testToTransferCollection(): void
    {
        $this->assertIsArray($this->transferMapper->toTransferCollection($this->transferData));
        $this->assertEquals('Lorem Ipsum', $this->transferMapper->toTransferCollection($this->transferData)[0]->getName());
    }
}
