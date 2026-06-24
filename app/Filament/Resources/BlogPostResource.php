<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title_id')->label('Judul (ID)')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('title_en')->label('Judul (EN)')->required(),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('blog_category_id')->label('Kategori')->relationship('category', 'name_id'),
                Forms\Components\TextInput::make('author')->label('Penulis')->default('ConWeb Team'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Textarea::make('excerpt_id')->label('Ringkasan (ID)')->rows(2),
                Forms\Components\Textarea::make('excerpt_en')->label('Ringkasan (EN)')->rows(2),
            ]),
            Forms\Components\FileUpload::make('cover_image')->label('Gambar Cover')->image()->directory('blog')->imageEditor(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Textarea::make('content_id')->label('Konten (ID)')->rows(8),
                Forms\Components\Textarea::make('content_en')->label('Konten (EN)')->rows(8),
            ]),
            Forms\Components\Grid::make(4)->schema([
                Forms\Components\DateTimePicker::make('published_at')->label('Tanggal Terbit')->default(now()),
                Forms\Components\TextInput::make('sort')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->label('Unggulan'),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('Cover'),
                Tables\Columns\TextColumn::make('title_id')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('category.name_id')->label('Kategori'),
                Tables\Columns\TextColumn::make('published_at')->label('Terbit')->date('d M Y')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
