<?php

namespace App\Filament\Resources\SeamediaServiceResource\Pages;

use App\Filament\Resources\SeamediaServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeamediaService extends EditRecord
{
    protected static string $resource = SeamediaServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
