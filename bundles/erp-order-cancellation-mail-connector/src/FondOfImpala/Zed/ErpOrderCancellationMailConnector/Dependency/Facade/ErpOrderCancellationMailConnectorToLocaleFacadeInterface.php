<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface ErpOrderCancellationMailConnectorToLocaleFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getCurrentLocale(): LocaleTransfer;

    /**
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocaleById(int $idLocale): LocaleTransfer;
}
