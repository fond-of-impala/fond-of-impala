<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer;

use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;

class ItemsCategorizer implements ItemsCategorizerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface
     */
    protected $itemMapper;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface
     */
    protected $itemFinder;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface
     */
    protected $itemsGrouper;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface $itemMapper
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface $itemFinder
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface $itemsGrouper
     */
    public function __construct(
        ItemMapperInterface $itemMapper,
        ItemFinderInterface $itemFinder,
        ItemsGrouperInterface $itemsGrouper
    ) {
        $this->itemMapper = $itemMapper;
        $this->itemFinder = $itemFinder;
        $this->itemsGrouper = $itemsGrouper;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return array<string, array<\Generated\Shared\Transfer\ItemTransfer>>
     */
    public function categorize(
        QuoteTransfer $quoteTransfer,
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): array {
        $groupedItemTransfers = $this->itemsGrouper->groupByQuote($quoteTransfer);
        $categorisedItemTransfers = [
            static::CATEGORY_ADDABLE => [],
            static::CATEGORY_REMOVABLE => [],
        ];

        foreach ($restCartsRequestAttributesTransfer->getItems() as $restCartItemTransfer) {
            $newQuantity = $this->resolveQuantityFromRequest($restCartItemTransfer);
            $oldItemTransfer = $this->itemFinder->findInGroupedItemsByRestCartItem(
                $groupedItemTransfers,
                $restCartItemTransfer,
            );

            if ($oldItemTransfer === null && $newQuantity > 0) {
                $categorisedItemTransfers[static::CATEGORY_ADDABLE][] = $this->itemMapper->fromRestCartItem(
                    $restCartItemTransfer,
                );

                continue;
            }

            if ($oldItemTransfer !== null && $newQuantity < $oldItemTransfer->getQuantity()) {
                $categorisedItemTransfers[static::CATEGORY_REMOVABLE][] = $this->itemMapper->fromRestCartItem(
                    $restCartItemTransfer,
                )->setQuantity(abs($newQuantity - $oldItemTransfer->getQuantity()));

                continue;
            }

            if ($oldItemTransfer !== null && $newQuantity > $oldItemTransfer->getQuantity()) {
                $categorisedItemTransfers[static::CATEGORY_ADDABLE][] = $this->itemMapper->fromRestCartItem(
                    $restCartItemTransfer,
                )->setQuantity($newQuantity - $oldItemTransfer->getQuantity());
            }
        }

        return $categorisedItemTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return int
     */
    protected function resolveQuantityFromRequest(RestCartItemTransfer $restCartItemTransfer): int
    {
        $newQuantity = $restCartItemTransfer->getQuantity();

        if (is_numeric($newQuantity)) {
            return (int)$newQuantity;
        }

        return 0;
    }
}
