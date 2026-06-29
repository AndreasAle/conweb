<?php

namespace App\Filament\Resources\StorePackageResource\Pages;

use App\Filament\Resources\StorePackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorePackage extends EditRecord
{
    protected static string $resource = StorePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
