<?php

namespace App\Services\Utils;

use App\Models\Position;

class PositionService
{
    public function getActivePosition($activeElection)
    {
        return Position::where('election_id', $activeElection->id)
            ->where('is_active', true)
            ->first();
    }
}
