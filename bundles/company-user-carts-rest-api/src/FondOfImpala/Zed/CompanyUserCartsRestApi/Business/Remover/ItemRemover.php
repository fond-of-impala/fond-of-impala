<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover;

use ArrayObject;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ItemRemover implements ItemRemoverInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface
     */
    protected $cartFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface $cartFacade
     */
    public function __construct(
        CompanyUserCartsRestApiToCartFacadeInterface $cartFacade
    ) {
        $this->cartFacade = $cartFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function removeMultiple(QuoteTransfer $quoteTransfer, array $itemTransfers): QuoteResponseTransfer
    {
        if (count($itemTransfers) === 0) {
            return (new QuoteResponseTransfer())
                ->setQuoteTransfer($quoteTransfer)
                ->setIsSuccessful(true);
        }

        $cartChangeTransfer = (new CartChangeTransfer())
            ->setQuote($quoteTransfer)
            ->setItems(new ArrayObject($itemTransfers));

        return $this->cartFacade->removeFromCart($cartChangeTransfer);
    }
}
