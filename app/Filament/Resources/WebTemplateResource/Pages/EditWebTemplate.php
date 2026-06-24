<?php

namespace App\Filament\Resources\WebTemplateResource\Pages;

use App\Filament\Resources\WebTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebTemplate extends EditRecord
{
    protected static string $resource = WebTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
