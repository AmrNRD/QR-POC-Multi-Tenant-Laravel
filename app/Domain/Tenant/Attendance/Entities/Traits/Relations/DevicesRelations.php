<?php

namespace App\Domain\Tenant\Attendance\Entities\Traits\Relations;

use App\Domain\Tenant\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait DevicesRelations
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
