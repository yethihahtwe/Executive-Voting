<?php

namespace App\Services\Utils;

use App\Models\Election;

class ElectionService
{
    public function getActiveElection(): Election|null
    {
        return Election::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }
}
