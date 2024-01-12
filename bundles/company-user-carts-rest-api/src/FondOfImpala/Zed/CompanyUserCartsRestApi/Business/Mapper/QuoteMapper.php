<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\StoreTransfer;

class QuoteMapper implements QuoteMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function fromRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        $quoteTransfer = new QuoteTransfer();

        if ($restCompanyUserCartsRequestTransfer->getCart() !== null) {
            $quoteTransfer = $this->fromRestCartsRequestAttributes($restCompanyUserCartsRequestTransfer->getCart());
        }

        $quoteTransfer->setCustomerReference($restCompanyUserCartsRequestTransfer->getCustomerReference())
            ->setCompanyUserReference($restCompanyUserCartsRequestTransfer->getCompanyUserReference());

        if ($restCompanyUserCartsRequestTransfer->getIdCustomer() !== null) {
            $customerTransfer = (new CustomerTransfer())
                ->setIdCustomer($restCompanyUserCartsRequestTransfer->getIdCustomer())
                ->setCustomerReference($restCompanyUserCartsRequestTransfer->getCustomerReference());

            $quoteTransfer->setCustomer($customerTransfer);
        }

        if ($restCompanyUserCartsRequestTransfer->getCompanyUserReference() !== null) {
            $companyUserTransfer = (new CompanyUserTransfer())
                ->setCompanyUserReference($restCompanyUserCartsRequestTransfer->getCompanyUserReference());

            $quoteTransfer->setCompanyUser($companyUserTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function fromRestCartsRequestAttributes(
        RestCartsRequestAttributesTransfer $restCartsRequestAttributesTransfer
    ): QuoteTransfer {
        $quoteTransfer = (new QuoteTransfer())
            ->fromArray($restCartsRequestAttributesTransfer->toArray(), true)
            ->setItems(new ArrayObject());

        if ($restCartsRequestAttributesTransfer->getCurrency() !== null) {
            $currencyTransfer = (new CurrencyTransfer())
                ->setCode($restCartsRequestAttributesTransfer->getCurrency());

            $quoteTransfer->setCurrency($currencyTransfer);
        }

        if ($restCartsRequestAttributesTransfer->getStore() !== null) {
            $storeTransfer = (new StoreTransfer())
                ->setName($restCartsRequestAttributesTransfer->getStore());

            $quoteTransfer->setStore($storeTransfer);
        }

        return $quoteTransfer;
    }
}
