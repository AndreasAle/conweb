<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $navigationLabel = 'Semua Layanan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('service')->columnSpanFull()->tabs([
                    Forms\Components\Tabs\Tab::make('Ringkasan')->schema([
                        Forms\Components\Select::make('icon')
                            ->label('Ikon')
                            ->options(\App\Support\Icons::options())
                            ->default('web')->required(),
                        Forms\Components\TextInput::make('slug')->label('Slug (untuk halaman /layanan/{slug})')
                            ->unique(ignoreRecord: true)
                            ->helperText('Isi untuk memberi layanan ini halaman detail sendiri.'),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title_id')->label('Judul (ID)')->required(),
                            Forms\Components\TextInput::make('title_en')->label('Judul (EN)')->required(),
                            Forms\Components\Textarea::make('desc_id')->label('Deskripsi (ID)')->required()->rows(3),
                            Forms\Components\Textarea::make('desc_en')->label('Deskripsi (EN)')->required()->rows(3),
                        ]),
                        Forms\Components\Repeater::make('features')
                            ->label('Poin Fitur')
                            ->schema([
                                Forms\Components\TextInput::make('id')->label('Fitur (ID)')->required(),
                                Forms\Components\TextInput::make('en')->label('Fitur (EN)')->required(),
                            ])->columns(2)->defaultItems(3),
                        Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                        Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    ]),
                    Forms\Components\Tabs\Tab::make('Halaman Detail')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('hero_title_id')->label('Judul Hero (ID)'),
                            Forms\Components\TextInput::make('hero_title_en')->label('Judul Hero (EN)'),
                            Forms\Components\TextInput::make('hero_subtitle_id')->label('Subjudul Hero (ID)'),
                            Forms\Components\TextInput::make('hero_subtitle_en')->label('Subjudul Hero (EN)'),
                        ]),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('body_id')->label('Isi Halaman (ID)')->rows(8),
                            Forms\Components\Textarea::make('body_en')->label('Isi Halaman (EN)')->rows(8),
                        ]),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('icon')->label('Ikon')->badge(),
                Tables\Columns\TextColumn::make('title_id')->label('Judul')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort')->label('Urutan')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
