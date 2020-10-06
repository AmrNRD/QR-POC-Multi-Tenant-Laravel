<?php

namespace App\Domain\Company\Entities\Traits\Relations;

use App\Domain\Company\Entities\Company;
use App\Infrastructure\TenancyModels\Website;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait CompanyRelations
{
    /**
     * @return HasOne
     */
    public function website(): HasOne
    {
        return $this->hasOne(Website::class);
    }
}
