<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;

class RestCartsAttributesMapper implements RestCartsAttributesMapperInterface
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapperInterface
     */
    protected $restCartsDiscountsMapper;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapperInterface
     */
    protected $restCartsTotalsMapper;

    /**
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapperInterface $restCartsDiscountsMapper
     * @param \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapperInterface $restCartsTotalsMapper
     */
    public function __construct(
        RestCartsDiscountsMapperInterface $restCartsDiscountsMapper,
        RestCartsTotalsMapperInterface $restCartsTotalsMapper
    ) {
        $this->restCartsDiscountsMapper = $restCartsDiscountsMapper;
        $this->restCartsTotalsMapper = $restCartsTotalsMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartsAttributesTransfer
     */
    public function fromQuote(
        QuoteTransfer $quoteTransfer
    ): RestCartsAttributesTransfer {
        return (new RestCartsAttributesTransfer())
            ->fromArray(
                $quoteTransfer->toArray(),
                true,
            )->setCurrency(
                $quoteTransfer->getCurrency() === null ? null : $quoteTransfer->getCurrency()->getCode(),
            )->setStore(
                $quoteTransfer->getStore() === null ? null : $quoteTransfer->getStore()->getName(),
            )->setTotals(
                $this->restCartsTotalsMapper->fromQuote($quoteTransfer),
            )->setDiscounts(
                new ArrayObject($this->restCartsDiscountsMapper->fromQuote($quoteTransfer)),
            );
    }
}
