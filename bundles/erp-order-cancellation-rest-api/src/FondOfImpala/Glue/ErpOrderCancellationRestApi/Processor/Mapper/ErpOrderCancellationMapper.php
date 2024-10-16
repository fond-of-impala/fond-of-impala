<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterPageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterSortTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\SortInterface;
use Symfony\Component\HttpFoundation\Request;

class ErpOrderCancellationMapper implements ErpOrderCancellationMapperInterface
{
    /**
     * @var array
     */
    protected const UUID_METHODS = [
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
        Request::METHOD_GET,
    ];

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer|null $attributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    public function createRequest(
        RestRequestInterface $restRequest,
        ?RestErpOrderCancellationAttributesTransfer $attributesTransfer = null
    ): RestErpOrderCancellationRequestTransfer {
        if ($attributesTransfer === null) {
            $attributesTransfer = $this->createAttributesFromRequest($restRequest);
        }

        return (new RestErpOrderCancellationRequestTransfer())
            ->setAttributes($attributesTransfer)
            ->setFilter($this->createFilterFromRequest($restRequest));
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer
     */
    public function createAttributesFromRequest(RestRequestInterface $restRequest): RestErpOrderCancellationAttributesTransfer
    {
        $data = $restRequest->getAttributesDataFromRequest();
        if ($data === null) {
            $data = [];
        }

        return (new RestErpOrderCancellationAttributesTransfer())
            ->fromArray($data, true)
            ->setUuid($this->getUuid($restRequest))
            ->setOriginator($this->getOriginator($restRequest))
            ->setOriginatorReference($this->getOriginatorCustomerUserReference($restRequest));
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    public function createFilterFromRequest(RestRequestInterface $restRequest): RestErpOrderCancellationFilterTransfer
    {
        $queryData = $restRequest->getHttpRequest()->query;
        $data = [];
        if ($queryData->count() > 0) {
            $data = $queryData->all();
            unset($data['page'], $data['sort']);
        }

        return (new RestErpOrderCancellationFilterTransfer())
            ->fromArray($data, true)
            ->setSort($this->recreateSortFilter($restRequest))
            ->setPage($this->recreatePageFilter($restRequest));
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    protected function getOriginatorCustomerUserReference(RestRequestInterface $restRequest): ?string
    {
        return $restRequest->getRestUser()->getNaturalIdentifier();
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected function getOriginator(RestRequestInterface $restRequest): RestCustomerTransfer
    {
        $restUser = $restRequest->getRestUser();

        return (new RestCustomerTransfer())->setIdCustomer($restUser->getSurrogateIdentifier())->setCustomerReference($restUser->getNaturalIdentifier());
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string|null
     */
    protected function getUuid(RestRequestInterface $restRequest): ?string
    {
        $meta = $restRequest->getMetadata();
        if (in_array($meta->getMethod(), static::UUID_METHODS, true)) {
            return $restRequest->getResource()->getId();
        }

        return null;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestErpOrderCancellationFilterSortTransfer>
     */
    public function recreateSortFilter(RestRequestInterface $restRequest): ArrayObject
    {
        $sortFilter = new ArrayObject();

        foreach ($restRequest->getSort() as $index => $sort) {
            $override = explode('_', $sort->getField());
            $direction = strtoupper(array_pop($override));
            $sortTransfer = (new RestErpOrderCancellationFilterSortTransfer())
                ->setField($sort->getField())
                ->setDirection($sort->getDirection());

            if ($direction === SortInterface::SORT_ASC || $direction === SortInterface::SORT_DESC) {
                $sortTransfer
                    ->setField(implode('_', $override))
                    ->setDirection($direction);
            }

            $sortFilter->append($sortTransfer);
        }

        return $sortFilter;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestErpOrderCancellationFilterPageTransfer|null
     */
    public function recreatePageFilter(RestRequestInterface $restRequest): ?RestErpOrderCancellationFilterPageTransfer
    {
        $page = $restRequest->getPage();
        if ($page === null) {
            return null;
        }

        return (new RestErpOrderCancellationFilterPageTransfer())
            ->setLimit($page->getLimit())
            ->setOffset($page->getOffset());
    }
}
