<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence;

use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiPersistenceFactory getFactory()
 */
class CompanyBusinessUnitsCartsRestApiRepository extends AbstractRepository implements CompanyBusinessUnitsCartsRestApiRepositoryInterface
{
    /**
     * @param string $quoteUuid
     *
     * @return int|null
     */
    public function getIdQuoteByQuoteUuid(string $quoteUuid): ?int
    {
        /** @var int|null $idQuote */
        $idQuote = $this->getFactory()
            ->getQuoteQuery()
            ->clear()
            ->filterByUuid($quoteUuid)
            ->select(SpyQuoteTableMap::COL_ID_QUOTE)
            ->findOne();

        return $idQuote;
    }
}
