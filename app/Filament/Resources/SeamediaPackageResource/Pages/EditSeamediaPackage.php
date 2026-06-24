<?php

namespace App\Filament\Resources\SeamediaPackageResource\Pages;

use App\Filament\Resources\SeamediaPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeamediaPackage extends EditRecord
{
    protected static string $resource = SeamediaPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
