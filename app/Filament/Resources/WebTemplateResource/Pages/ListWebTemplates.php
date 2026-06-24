<?php

namespace App\Filament\Resources\WebTemplateResource\Pages;

use App\Filament\Resources\WebTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebTemplates extends ListRecords
{
    protected static string $resource = WebTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
