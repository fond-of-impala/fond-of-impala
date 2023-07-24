<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator;

use Generated\Shared\Transfer\EventEntityTransfer;

interface CompanyTypeRoleExportValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return bool
     */
    public function validate(EventEntityTransfer $eventEntityTransfer): bool;
}
