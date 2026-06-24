<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Catat waktu update jika tahap pengerjaan berubah.
        if (($data['work_status'] ?? null) !== $this->record->work_status) {
            $data['status_updated_at'] = now();
        }

        return $data;
    }
}
