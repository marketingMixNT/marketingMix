<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Category::getForm()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('posts_count', 'asc')
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label('Tytuł')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Liczba postów')
                    ->counts('posts')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_id')
                    ->label('Autor')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $user = User::find($state);
                        return $user ? $user->name : 'brak';
                    })
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)->format('d-m-Y');
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Data modyfikacji')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)->format('d-m-Y');
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return ('Kategorie');
    }
    public static function getPluralLabel(): string
    {
        return ('Kategorie');
    }

    public static function getLabel(): string
    {
        return ('Kategoria');
    }
}