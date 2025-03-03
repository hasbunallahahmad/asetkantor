<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenugasanKendaraanResource\Pages;
use App\Filament\Resources\PenugasanKendaraanResource\RelationManagers;
use App\Models\PenugasanKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenugasanKendaraanResource extends Resource
{
    protected static ?string $model = PenugasanKendaraan::class;

    protected static ?string $navigationIcon = 'heroicon-c-briefcase';
    protected static ?string $navigationGroup = 'Administrasi';
    protected static ?int $navigationSort = 5;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // Menu tidak akan muncul di sidebar
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPenugasanKendaraans::route('/'),
            'create' => Pages\CreatePenugasanKendaraan::route('/create'),
            'edit' => Pages\EditPenugasanKendaraan::route('/{record}/edit'),
        ];
    }
}
