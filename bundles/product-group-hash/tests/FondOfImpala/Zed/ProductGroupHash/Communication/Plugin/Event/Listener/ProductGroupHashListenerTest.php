<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Listener;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Product\Dependency\ProductEvents;

class ProductGroupHashListenerTest extends Unit
{
    protected ProductAbstractTransfer|MockObject $productAbstractTransferMock;

    protected MockObject|LocalizedAttributesTransfer $localizedAttributesTransferMock;

    protected MockObject|LocaleTransfer $localeTransferMocks;

    protected ProductGroupHashListener $productGroupHashListener;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localizedAttributesTransferMock = $this->getMockBuilder(LocalizedAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransferMocks = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productGroupHashListener = new ProductGroupHashListener();
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        $eventName = ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE;

        $localizedAttributesTransferMocks = [
            $this->localizedAttributesTransferMock,
        ];

        $localeName = 'en_US';

        $attributes = [
            'model' => 'foo',
            'style' => 'bar',
            'collection' => ['baz', 'qux'],
        ];

        $groupHash = sha1(
            sprintf(
                '%s#%s#%s',
                $attributes['model'],
                $attributes['style'],
                implode(',', $attributes['collection']),
            ),
        );

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getLocalizedAttributes')
            ->willReturn(new ArrayObject($localizedAttributesTransferMocks));

        $this->localizedAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransferMocks);

        $this->localeTransferMocks->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn($localeName);

        $this->localizedAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($attributes);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('setGroupHash')
            ->with($groupHash)
            ->willReturn($this->productAbstractTransferMock);

        $this->productGroupHashListener->handle($this->productAbstractTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithInvalidEventName(): void
    {
        $eventName = 'foo';

        $this->productAbstractTransferMock->expects(static::never())
            ->method('getLocalizedAttributes');

        $this->localizedAttributesTransferMock->expects(static::never())
            ->method('getAttributes');

        $this->productAbstractTransferMock->expects(static::never())
            ->method('setGroupHash');

        $this->productGroupHashListener->handle($this->productAbstractTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithUnsupportedLocaleNames(): void
    {
        $eventName = ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE;

        $localizedAttributesTransferMocks = [
            $this->localizedAttributesTransferMock,
        ];

        $localeName = 'de_DE';

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getLocalizedAttributes')
            ->willReturn(new ArrayObject($localizedAttributesTransferMocks));

        $this->localizedAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransferMocks);

        $this->localeTransferMocks->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn($localeName);

        $this->localizedAttributesTransferMock->expects(static::never())
            ->method('getAttributes');

        $this->productAbstractTransferMock->expects(static::never())
            ->method('setGroupHash');

        $this->productGroupHashListener->handle($this->productAbstractTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithInvalidAttributes(): void
    {
        $eventName = ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE;

        $localizedAttributesTransferMocks = [
            $this->localizedAttributesTransferMock,
        ];

        $localeName = 'en_US';

        $attributes = [
            'model' => 'foo',
            'style' => 'bar',
        ];

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getLocalizedAttributes')
            ->willReturn(new ArrayObject($localizedAttributesTransferMocks));

        $this->localizedAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransferMocks);

        $this->localeTransferMocks->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn($localeName);

        $this->localizedAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($attributes);

        $this->productAbstractTransferMock->expects(static::never())
            ->method('setGroupHash');

        $this->productGroupHashListener->handle($this->productAbstractTransferMock, $eventName);
    }

    /**
     * @return void
     */
    public function testHandleWithInvalidTransfer(): void
    {
        $eventName = ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE;

        $transferMock = $this->getMockBuilder(TransferInterface::class)
           ->disableOriginalConstructor()
           ->getMock();

        $this->productGroupHashListener->handle($transferMock, $eventName);
    }
}
