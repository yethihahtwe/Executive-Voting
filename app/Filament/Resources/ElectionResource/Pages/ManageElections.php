<?php

namespace App\Filament\Resources\ElectionResource\Pages;

use App\Filament\Resources\ElectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageElections extends ManageRecords
{
    protected static string $resource = ElectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->successNotificationTitle('Election successfully created.'),
        ];
    }
}
