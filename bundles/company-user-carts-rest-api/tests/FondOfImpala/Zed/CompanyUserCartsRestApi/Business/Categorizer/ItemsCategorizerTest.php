<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer;

use ArrayObject;
use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;

class ItemsCategorizerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemMapperMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemFinderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemsGrouperMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartRequestAttributesTransferMock;

    /**
     * @var array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $itemTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $newItemTransferMocks;

    /**
     * @var array<\Generated\Shared\Transfer\RestCartItemTransfer|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $restCartItemTransferMocks;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizer
     */
    protected $itemsCategorizer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemMapperMock = $this->getMockBuilder(ItemMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemFinderMock = $this->getMockBuilder(ItemFinderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemsGrouperMock = $this->getMockBuilder(ItemsGrouperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartRequestAttributesTransferMock = $this->getMockBuilder(RestCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            'foo.bar-1' => $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            'foo.bar-2' => $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->newItemTransferMocks = [
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restCartItemTransferMocks = [
            $this->getMockBuilder(RestCartItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestCartItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestCartItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->itemsCategorizer = new ItemsCategorizer(
            $this->itemMapperMock,
            $this->itemFinderMock,
            $this->itemsGrouperMock,
        );
    }

    /**
     * @return void
     */
    public function testCategorize(): void
    {
        $self = $this;

        $newQuantities = [2, 0, 2];
        $currentQuantities = [1, 1];

        $this->itemsGrouperMock->expects(static::atLeastOnce())
            ->method('groupByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->itemTransferMocks);

        $this->restCartRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject($this->restCartItemTransferMocks));

        $callCount = $this->atLeastOnce();
        $this->itemFinderMock->expects($callCount)
            ->method('findInGroupedItemsByRestCartItem')
            ->willReturnCallback(static function (array $groupedItemTransfers, RestCartItemTransfer $restCartItemTransfer) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[0], $restCartItemTransfer);

                        return null;
                    case 2:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[1], $restCartItemTransfer);

                        return $self->itemTransferMocks['foo.bar-1'];
                    case 3:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[2], $restCartItemTransfer);

                        return $self->itemTransferMocks['foo.bar-2'];
                }

                throw new Exception('Unexpected call count');
            });

        $callCount2 = $this->atLeastOnce();
        $this->itemMapperMock->expects($callCount2)
            ->method('fromRestCartItem')
            ->willReturnCallback(static function (RestCartItemTransfer $restCartItemTransfer) use ($self, $callCount2) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount2, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($self->restCartItemTransferMocks[0], $restCartItemTransfer);

                        return $self->newItemTransferMocks[0];
                    case 2:
                        $self->assertSame($self->restCartItemTransferMocks[1], $restCartItemTransfer);

                        return $self->newItemTransferMocks[1];
                    case 3:
                        $self->assertSame($self->restCartItemTransferMocks[2], $restCartItemTransfer);

                        return $self->newItemTransferMocks[2];
                }

                throw new Exception('Unexpected call count');
            });

        $this->restCartItemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[0]);

        $this->restCartItemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[1]);

        $this->itemTransferMocks['foo.bar-1']->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($currentQuantities[0]);

        $this->newItemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('setQuantity')
            ->with(1)
            ->willReturn($this->newItemTransferMocks[1]);

        $this->restCartItemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[2]);

        $this->itemTransferMocks['foo.bar-2']->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($currentQuantities[1]);

        $this->newItemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('setQuantity')
            ->with(1)
            ->willReturn($this->newItemTransferMocks[2]);

        $categorisedItemTransfers = $this->itemsCategorizer->categorize(
            $this->quoteTransferMock,
            $this->restCartRequestAttributesTransferMock,
        );

        static::assertCount(2, $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE]);
        static::assertCount(1, $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_REMOVABLE]);

        static::assertEquals(
            $this->newItemTransferMocks[0],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE][0],
        );

        static::assertEquals(
            $this->newItemTransferMocks[1],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_REMOVABLE][0],
        );

        static::assertEquals(
            $this->newItemTransferMocks[2],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE][1],
        );
    }

    /**
     * @return void
     */
    public function testCategorizeWithString(): void
    {
        $self = $this;

        $newQuantities = [2, 0, ''];
        $currentQuantities = [1, 1];

        $this->itemsGrouperMock->expects(static::atLeastOnce())
            ->method('groupByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->itemTransferMocks);

        $this->restCartRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject($this->restCartItemTransferMocks));

        $callCount = $this->atLeastOnce();
        $this->itemFinderMock->expects($callCount)
            ->method('findInGroupedItemsByRestCartItem')
            ->willReturnCallback(static function (array $groupedItemTransfers, RestCartItemTransfer $restCartItemTransfer) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[0], $restCartItemTransfer);

                        return null;
                    case 2:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[1], $restCartItemTransfer);

                        return $self->itemTransferMocks['foo.bar-1'];
                    case 3:
                        $self->assertSame($self->itemTransferMocks, $groupedItemTransfers);
                        $self->assertSame($self->restCartItemTransferMocks[2], $restCartItemTransfer);

                        return $self->itemTransferMocks['foo.bar-2'];
                }

                throw new Exception('Unexpected call count');
            });

        $callCount2 = $this->atLeastOnce();
        $this->itemMapperMock->expects($callCount2)
            ->method('fromRestCartItem')
            ->willReturnCallback(static function (RestCartItemTransfer $restCartItemTransfer) use ($self, $callCount2) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount2, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount2->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame($self->restCartItemTransferMocks[0], $restCartItemTransfer);

                        return $self->newItemTransferMocks[0];
                    case 2:
                        $self->assertSame($self->restCartItemTransferMocks[1], $restCartItemTransfer);

                        return $self->newItemTransferMocks[1];
                    case 3:
                        $self->assertSame($self->restCartItemTransferMocks[2], $restCartItemTransfer);

                        return $self->newItemTransferMocks[2];
                }

                throw new Exception('Unexpected call count');
            });

        $this->restCartItemTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[0]);

        $this->restCartItemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[1]);

        $this->itemTransferMocks['foo.bar-1']->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($currentQuantities[0]);

        $this->newItemTransferMocks[1]->expects(static::atLeastOnce())
            ->method('setQuantity')
            ->with(1)
            ->willReturn($this->newItemTransferMocks[1]);

        $this->restCartItemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($newQuantities[2]);

        $this->itemTransferMocks['foo.bar-2']->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($currentQuantities[1]);

        $this->newItemTransferMocks[2]->expects(static::atLeastOnce())
            ->method('setQuantity')
            ->with(1)
            ->willReturn($this->newItemTransferMocks[2]);

        $categorisedItemTransfers = $this->itemsCategorizer->categorize(
            $this->quoteTransferMock,
            $this->restCartRequestAttributesTransferMock,
        );

        static::assertCount(1, $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE]);
        static::assertCount(2, $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_REMOVABLE]);

        static::assertEquals(
            $this->newItemTransferMocks[0],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE][0],
        );

        static::assertEquals(
            $this->newItemTransferMocks[1],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_REMOVABLE][0],
        );

        static::assertEquals(
            $this->newItemTransferMocks[2],
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE][0],
        );
    }
}
