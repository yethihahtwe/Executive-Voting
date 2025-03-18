<?php

namespace App\Filament\Imports;

use App\Models\Representative;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class RepresentativeImporter extends Importer
{
    protected static ?string $model = Representative::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('organization')
                ->requiredMapping()
                ->relationship(resolveUsing: 'abbreviation')
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Representative
    {
        // return Representative::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Representative();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your representative import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
