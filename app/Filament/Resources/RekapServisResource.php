<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapServisResource\Pages;
use App\Filament\Resources\RekapServisResource\Pages\ListRekapServis;
use App\Filament\Resources\RekapServisResource\RelationManagers;
use App\Models\RekapServis;
use App\Models\ServisKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekapServisResource extends Resource
{
    protected static ?string $model = ServisKendaraan::class;
    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-check';
    protected static ?string $navigationGroup = 'Laporan & Export';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([

    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_servis')->label('Tanggal Servis')->sortable(),
                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')->label('Plat Nomor')->sortable(),
                Tables\Columns\TextColumn::make('jenis_servis')->label('Jenis Servis'),
                Tables\Columns\TextColumn::make('biaya')->label('Biaya')->money('IDR'),
                Tables\Columns\TextColumn::make('bengkel')->label('Bengkel'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan')->limit(50),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('plat_nomor')
                    ->relationship('kendaraan', 'plat_nomor')
                    ->label('Plat Nomor'),
            ])
            ->actions([
                Tables\Actions\Action::make('Export PDF')
                    ->icon('heroicon-o-download')
                    ->url(fn() => route('export.pdf.servis'))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('Export Excel')
                    ->icon('heroicon-o-download')
                    ->url(fn() => route('export.excel.servis'))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListRekapServis::route('/'),
            // 'create' => Pages\CreateRekapServis::route('/create'),
            // 'edit' => Pages\EditRekapServis::route('/{record}/edit'),
        ];
    }
}
