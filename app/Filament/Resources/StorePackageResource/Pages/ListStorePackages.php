<?php

namespace App\Filament\Resources\StorePackageResource\Pages;

use App\Filament\Resources\StorePackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorePackages extends ListRecords
{
    protected static string $resource = StorePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
