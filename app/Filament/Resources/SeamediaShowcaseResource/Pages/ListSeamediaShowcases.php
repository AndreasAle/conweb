<?php

namespace App\Filament\Resources\SeamediaShowcaseResource\Pages;

use App\Filament\Resources\SeamediaShowcaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeamediaShowcases extends ListRecords
{
    protected static string $resource = SeamediaShowcaseResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
