<?php
namespace App\Common\Helpers;

trait ActiveCompany
{

    /**
     * check whether current system(Tenant) company is active or not
     * @return bool
     */
    public function isActiveCompany():bool
    {
        $website = \Hyn\Tenancy\Facades\TenancyFacade::website();
        if ($website->company->active != "active")
            return false;
        return true;
    }


}
