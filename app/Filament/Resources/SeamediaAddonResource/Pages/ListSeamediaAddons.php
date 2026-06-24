<?php

namespace App\Filament\Resources\SeamediaAddonResource\Pages;

use App\Filament\Resources\SeamediaAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeamediaAddons extends ListRecords
{
    protected static string $resource = SeamediaAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
