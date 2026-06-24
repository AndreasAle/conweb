<?php

namespace App\Filament\Resources\SeamediaPackageResource\Pages;

use App\Filament\Resources\SeamediaPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeamediaPackages extends ListRecords
{
    protected static string $resource = SeamediaPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
