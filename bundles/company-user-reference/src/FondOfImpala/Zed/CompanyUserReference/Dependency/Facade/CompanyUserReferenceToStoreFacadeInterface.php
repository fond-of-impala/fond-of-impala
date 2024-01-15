<?php

namespace FondOfImpala\Zed\CompanyUserReference\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface CompanyUserReferenceToStoreFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
