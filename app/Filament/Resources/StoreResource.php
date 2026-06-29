<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'E-commerce by Conweb';

    protected static ?string $navigationLabel = 'Toko UMKM';

    protected static ?string $modelLabel = 'Toko';

    protected static ?string $pluralModelLabel = 'Toko UMKM';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identitas Toko')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')->label('Nama Toko')->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set, $context) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                    Forms\Components\TextInput::make('slug')->label('Slug (URL toko)')->required()->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('URL publik: /store/{slug}'),
                ]),
                Forms\Components\TextInput::make('tagline')->label('Tagline')->maxLength(255),
                Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
            ]),

            Forms\Components\Section::make('Kepemilikan & Paket')->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('user_id')->label('Pemilik (User)')
                        ->relationship('user', 'name')->searchable()->preload()
                        ->helperText('User pemilik toko. Bisa dikosongkan dulu.'),
                    Forms\Components\Select::make('store_package_id')->label('Paket Layanan')
                        ->relationship('package', 'name')->searchable()->preload(),
                    Forms\Components\Select::make('store_template_id')->label('Template Tampilan')
                        ->relationship('template', 'name')->searchable()->preload(),
                ]),
            ]),

            Forms\Components\Section::make('Kontak & Alamat')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('whatsapp_number')->label('Nomor WhatsApp')->required()
                        ->placeholder('08xxxxxxxxxx')->helperText('Order customer dikirim ke nomor ini.'),
                    Forms\Components\TextInput::make('email')->label('Email')->email(),
                ]),
                Forms\Components\TextInput::make('address')->label('Alamat'),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('city')->label('Kota'),
                    Forms\Components\TextInput::make('province')->label('Provinsi'),
                    Forms\Components\TextInput::make('postal_code')->label('Kode Pos'),
                ]),
            ]),

            Forms\Components\Section::make('Media & Brand')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\FileUpload::make('logo')->label('Logo')->image()->directory('stores/logos')->imageEditor(),
                    Forms\Components\FileUpload::make('banner')->label('Banner')->image()->directory('stores/banners')->imageEditor(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\ColorPicker::make('primary_color')->label('Warna Utama')->default('#2563eb'),
                    Forms\Components\ColorPicker::make('secondary_color')->label('Warna Sekunder')->default('#0a1530'),
                ]),
            ])->collapsed(),

            Forms\Components\Section::make('Marketplace & Sosial Media')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                    Forms\Components\TextInput::make('tiktok_url')->label('TikTok')->url(),
                    Forms\Components\TextInput::make('shopee_url')->label('Shopee')->url(),
                    Forms\Components\TextInput::make('tokopedia_url')->label('Tokopedia')->url(),
                ]),
            ])->collapsed(),

            Forms\Components\Section::make('SEO & Status')->schema([
                Forms\Components\TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->label('Meta Description')->rows(2)->maxLength(255),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('is_active')->label('Toko Aktif')->default(true)
                        ->helperText('Nonaktif = storefront tidak bisa diakses publik.'),
                    Forms\Components\Toggle::make('is_featured')->label('Toko Unggulan'),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->label('Logo')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable()
                    ->description(fn (Store $r) => '/store/'.$r->slug),
                Tables\Columns\TextColumn::make('user.name')->label('Pemilik')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('package.name')->label('Paket')->badge()->placeholder('—'),
                Tables\Columns\TextColumn::make('products_count')->label('Produk')->counts('products')->badge(),
                Tables\Columns\TextColumn::make('orders_count')->label('Order')->counts('orders')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Unggulan')->boolean()->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Unggulan'),
            ])
            ->actions([
                Tables\Actions\Action::make('visit')->label('Lihat Toko')->icon('heroicon-o-eye')
                    ->url(fn (Store $r) => route('store.home', $r->slug))->openUrlInNewTab()
                    ->visible(fn (Store $r) => $r->is_active),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
