<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency;

interface CompanyUserCompanyAssignerEvents
{
    /**
     * @var string
     */
    public const MANUFACTURER_USER_MARK_FOR_ASSIGMENT = 'CompanyUserCompanyAssigner.manufacturer_user.mark_for_assignment';

    /**
     * @var string
     */
    public const MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE = 'CompanyUserCompanyAssigner.manufacturer_company_user.company_role_update';
}
