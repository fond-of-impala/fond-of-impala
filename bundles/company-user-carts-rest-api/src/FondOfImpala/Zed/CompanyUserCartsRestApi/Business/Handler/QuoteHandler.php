<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler;

use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer;

class QuoteHandler implements QuoteHandlerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface
     */
    protected $itemsCategorizer;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface
     */
    protected $itemAdder;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface
     */
    protected $itemRemover;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface $itemsCategorizer
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface $itemAdder
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface $itemRemover
     */
    public function __construct(
        ItemsCategorizerInterface $itemsCategorizer,
        ItemAdderInterface $itemAdder,
        ItemRemoverInterface $itemRemover
    ) {
        $this->itemsCategorizer = $itemsCategorizer;
        $this->itemAdder = $itemAdder;
        $this->itemRemover = $itemRemover;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUserCartsResponseTransfer
     */
    public function handle(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): RestCompanyUserCartsResponseTransfer {
        $restCartsRequestAttributesTransfer = $restCompanyUserCartsRequestTransfer->getCart();

        if ($restCartsRequestAttributesTransfer === null) {
            return (new RestCompanyUserCartsResponseTransfer())
                ->setQuote($quoteTransfer)
                ->setIsSuccessful(true);
        }

        $categorisedItemTransfers = $this->itemsCategorizer->categorize(
            $quoteTransfer,
            $restCartsRequestAttributesTransfer,
        );

        $quoteResponseTransfer = $this->itemAdder->addMultiple(
            $quoteTransfer,
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_ADDABLE],
        );

        if (!$quoteResponseTransfer->getIsSuccessful() || $quoteResponseTransfer->getQuoteTransfer() === null) {
            return (new RestCompanyUserCartsResponseTransfer())
                ->setErrors($quoteResponseTransfer->getErrors())
                ->setIsSuccessful(false);
        }

        $quoteResponseTransfer = $this->itemRemover->removeMultiple(
            $quoteResponseTransfer->getQuoteTransfer(),
            $categorisedItemTransfers[ItemsCategorizerInterface::CATEGORY_REMOVABLE],
        );

        return (new RestCompanyUserCartsResponseTransfer())
            ->setQuote($quoteResponseTransfer->getQuoteTransfer())
            ->setErrors($quoteResponseTransfer->getErrors())
            ->setIsSuccessful($quoteResponseTransfer->getIsSuccessful());
    }
}
