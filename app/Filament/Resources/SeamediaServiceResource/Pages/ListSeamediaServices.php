<?php

namespace App\Filament\Resources\SeamediaServiceResource\Pages;

use App\Filament\Resources\SeamediaServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeamediaServices extends ListRecords
{
    protected static string $resource = SeamediaServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
