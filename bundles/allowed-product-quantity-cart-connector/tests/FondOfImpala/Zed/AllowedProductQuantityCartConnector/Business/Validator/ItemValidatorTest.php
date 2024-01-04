<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ItemValidatorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $allowedProductQuantityReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    private ?MockObject $allowedProductQuantityTransferMock = null;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidator
     */
    protected $itemValidator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityReaderMock = $this->getMockBuilder(AllowedProductQuantityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemValidator = new ItemValidator($this->allowedProductQuantityReaderMock);
    }

    /**
     * @return void
     */
    public function testValidateQuantitySmallerMin(): void
    {
        $this->allowedProductQuantityReaderMock->expects(static::atLeastOnce())
            ->method('getByItem')
            ->with($this->itemTransferMock)
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMin')
            ->willReturn(5);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMax')
            ->willReturn(6);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityInterval')
            ->willReturn(2);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(2);

        $messages = $this->itemValidator->validate($this->itemTransferMock);

        static::assertCount(1, $messages);
        static::assertEquals(ItemValidator::MESSAGE_TYPE_ERROR, $messages[0]->getType());
        static::assertEquals(ItemValidator::MESSAGE_QUANTITY_MIN_NOT_FULFILLED, $messages[0]->getValue());
    }

    /**
     * @return void
     */
    public function testValidateQuantityBiggerMax(): void
    {
        $this->allowedProductQuantityReaderMock->expects(static::atLeastOnce())
            ->method('getByItem')
            ->with($this->itemTransferMock)
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMin')
            ->willReturn(5);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMax')
            ->willReturn(6);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityInterval')
            ->willReturn(2);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(10);

        $messages = $this->itemValidator->validate($this->itemTransferMock);

        static::assertCount(1, $messages);
        static::assertEquals(ItemValidator::MESSAGE_TYPE_ERROR, $messages[0]->getType());
        static::assertEquals(ItemValidator::MESSAGE_QUANTITY_MAX_NOT_FULFILLED, $messages[0]->getValue());
    }

    /**
     * @return void
     */
    public function testValidateQuantityModuloInterval(): void
    {
        $this->allowedProductQuantityReaderMock->expects(static::never())
            ->method('getByItem');

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMin')
            ->willReturn(5);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityMax')
            ->willReturn(6);

        $this->allowedProductQuantityTransferMock->expects(static::atLeastOnce())
            ->method('getQuantityInterval')
            ->willReturn(2);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(3);

        $messages = $this->itemValidator->validate($this->itemTransferMock, $this->allowedProductQuantityTransferMock);

        static::assertCount(2, $messages);
        static::assertEquals(ItemValidator::MESSAGE_TYPE_ERROR, $messages[0]->getType());
        static::assertEquals(ItemValidator::MESSAGE_TYPE_ERROR, $messages[1]->getType());
        static::assertEquals(ItemValidator::MESSAGE_QUANTITY_MIN_NOT_FULFILLED, $messages[0]->getValue());
        static::assertEquals(ItemValidator::MESSAGE_QUANTITY_INTERVAL_NOT_FULFILLED, $messages[1]->getValue());
    }

    /**
     * @return void
     */
    public function testValidateIsNotSuccessful(): void
    {
        $this->allowedProductQuantityReaderMock->expects(static::atLeastOnce())
            ->method('getByItem')
            ->with($this->itemTransferMock)
            ->willReturn(null);

        static::assertCount(0, $this->itemValidator->validate($this->itemTransferMock));
    }
}
