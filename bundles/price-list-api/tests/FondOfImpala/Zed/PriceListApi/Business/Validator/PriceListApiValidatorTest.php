<?php


namespace FondOfImpala\Zed\PriceListApi\Business\Validator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

class PriceListApiValidatorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidator
     */
    protected $priceListApiValidator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var array
     */
    protected $transferData;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferData = [
            [
                'name' => 'Lorem Ipsum',
                'price_list_entries' => [],
            ],
        ];

        $this->priceListApiValidator = new PriceListApiValidator();
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->apiRequestTransferMock->expects($this->atLeastOnce())
            ->method('getApiDataOrFail')
            ->willReturn($this->apiDataTransferMock);

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($this->transferData);

        $this->assertIsArray($this->priceListApiValidator->validate($this->apiRequestTransferMock));
    }
}
