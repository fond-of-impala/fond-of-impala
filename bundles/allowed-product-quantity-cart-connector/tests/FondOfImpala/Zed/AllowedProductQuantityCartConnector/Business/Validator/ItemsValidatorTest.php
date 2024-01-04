<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;

class ItemsValidatorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Reader\AllowedProductQuantityReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $allowedProductQuantityReaderMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidatorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemValidatorMock;

    /**
     * @var \ArrayObject<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $itemTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\AllowedProductQuantityTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $allowedProductQuantityTransferMocks;

    /**
     * @var \Generated\Shared\Transfer\MessageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $messageTransferMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemsValidator
     */
    protected $itemsValidator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityReaderMock = $this->getMockBuilder(AllowedProductQuantityReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemValidatorMock = $this->getMockBuilder(ItemValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = new ArrayObject([
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
           $this->getMockBuilder(ItemTransfer::class)
               ->disableOriginalConstructor()
               ->getMock(),
        ]);

        $this->allowedProductQuantityTransferMocks = [
            $this->getMockBuilder(AllowedProductQuantityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(AllowedProductQuantityTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->messageTransferMock = $this->getMockBuilder(MessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemsValidator = new ItemsValidator(
            $this->allowedProductQuantityReaderMock,
            $this->itemValidatorMock,
        );
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $abstractSkus = ['FOO-001-001', 'FOO-001-002', 'FOO-001-003'];
        $groupKeys = ['GROUP.FOO-001-001', 'GROUP.FOO-001-002', 'GROUP.FOO-001-003'];
        $allowedProductQuantityTransferMock = [
            $abstractSkus[0] => $this->allowedProductQuantityTransferMocks[0],
            $abstractSkus[2] => $this->allowedProductQuantityTransferMocks[1],
        ];

        $this->allowedProductQuantityReaderMock->expects(static::atLeastOnce())
            ->method('getGroupedByItems')
            ->with($this->itemTransferMocks)
            ->willReturn($allowedProductQuantityTransferMock);

        $this->itemTransferMocks->offsetGet(0)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[0]);

        $this->itemTransferMocks->offsetGet(0)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[0]);

        $this->itemValidatorMock->expects(static::atLeastOnce())
            ->method('validate')
            ->withConsecutive(
                [$this->itemTransferMocks->offsetGet(0), $this->allowedProductQuantityTransferMocks[0]],
                [$this->itemTransferMocks->offsetGet(2), $this->allowedProductQuantityTransferMocks[1]],
            )->willReturnOnConsecutiveCalls(
                new ArrayObject(),
                new ArrayObject([$this->messageTransferMock]),
            );

        $this->itemTransferMocks->offsetGet(1)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[1]);

        $this->itemTransferMocks->offsetGet(1)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[1]);

        $this->itemTransferMocks->offsetGet(2)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[2]);

        $this->itemTransferMocks->offsetGet(2)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[2]);

        $messageTransfers = $this->itemsValidator->validate($this->itemTransferMocks);

        static::assertArrayHasKey($groupKeys[2], $messageTransfers);
        static::assertContains($this->messageTransferMock, $messageTransfers[$groupKeys[2]]);
    }

    /**
     * @return void
     */
    public function testValidateAndAppendResult(): void
    {
        $abstractSkus = ['FOO-001-001', 'FOO-001-002', 'FOO-001-003'];
        $groupKeys = ['GROUP.FOO-001-001', 'GROUP.FOO-001-002', 'GROUP.FOO-001-003'];
        $allowedProductQuantityTransferMock = [
            $abstractSkus[0] => $this->allowedProductQuantityTransferMocks[0],
            $abstractSkus[2] => $this->allowedProductQuantityTransferMocks[1],
        ];

        $this->allowedProductQuantityReaderMock->expects(static::atLeastOnce())
            ->method('getGroupedByItems')
            ->with($this->itemTransferMocks)
            ->willReturn($allowedProductQuantityTransferMock);

        $this->itemTransferMocks->offsetGet(0)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[0]);

        $this->itemTransferMocks->offsetGet(0)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[0]);

        $this->itemValidatorMock->expects(static::atLeastOnce())
            ->method('validate')
            ->withConsecutive(
                [$this->itemTransferMocks->offsetGet(0), $this->allowedProductQuantityTransferMocks[0]],
                [$this->itemTransferMocks->offsetGet(2), $this->allowedProductQuantityTransferMocks[1]],
            )->willReturnOnConsecutiveCalls(
                new ArrayObject(),
                new ArrayObject([$this->messageTransferMock]),
            );

        $this->itemTransferMocks->offsetGet(1)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[1]);

        $this->itemTransferMocks->offsetGet(1)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[1]);

        $this->itemTransferMocks->offsetGet(2)->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKeys[2]);

        $this->itemTransferMocks->offsetGet(2)->expects(static::atLeastOnce())
            ->method('getAbstractSku')
            ->willReturn($abstractSkus[2]);

        $this->itemTransferMocks->offsetGet(2)->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->with($this->messageTransferMock)
            ->willReturn($this->itemTransferMocks);

        static::assertEquals(
            $this->itemTransferMocks,
            $this->itemsValidator->validateAndAppendResult($this->itemTransferMocks),
        );
    }
}
