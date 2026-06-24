<?php

namespace App\Filament\Resources\SeamediaAddonResource\Pages;

use App\Filament\Resources\SeamediaAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeamediaAddon extends EditRecord
{
    protected static string $resource = SeamediaAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
