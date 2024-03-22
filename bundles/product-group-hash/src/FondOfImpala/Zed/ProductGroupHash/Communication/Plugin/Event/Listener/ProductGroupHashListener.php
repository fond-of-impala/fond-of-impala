<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Listener;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\ProductEvents;

class ProductGroupHashListener extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param string $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if (
            $eventName !== ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE
            && $eventName !== ProductEvents::PRODUCT_ABSTRACT_BEFORE_UPDATE
        ) {
            return;
        }

        if (!($transfer instanceof ProductAbstractTransfer)) {
            return;
        }

        foreach ($transfer->getLocalizedAttributes() as $localizedAttributeTransfer) {
            $localeTransfer = $localizedAttributeTransfer->getLocale();
            if ($localeTransfer === null) {
                continue;
            }
            if ($localeTransfer->getLocaleName() !== 'en_US') {
                continue;
            }

            $attributes = $localizedAttributeTransfer->getAttributes();

            if (!isset($attributes['model'], $attributes['style'], $attributes['collection'])) {
                continue;
            }

            $groupHash = sha1(
                sprintf(
                    '%s#%s#%s',
                    $attributes['model'],
                    $attributes['style'],
                    is_array($attributes['collection']) ? implode(',', $attributes['collection']) : $attributes['collection'],
                ),
            );

            $transfer->setGroupHash($groupHash);

            break;
        }
    }
}
