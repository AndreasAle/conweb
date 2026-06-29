<?php

namespace App\Filament\Resources\StoreTemplateResource\Pages;

use App\Filament\Resources\StoreTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoreTemplates extends ListRecords
{
    protected static string $resource = StoreTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
