<?php

namespace App\Infrastructure\TenancyModels;

use App\Domain\Company\Entities\Company;
use Hyn\Tenancy\Models\Website as HynWebsite;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends HynWebsite
{


    /**
     * @return mixed
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
