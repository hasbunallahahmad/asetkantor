<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogAktivitasResource\Pages;
use App\Filament\Resources\LogAktivitasResource\RelationManagers;
use App\Models\LogAktivitas;
use App\Models\Pengguna;
use App\Models\Kendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class LogAktivitasResource extends Resource
{
    protected static ?string $model = LogAktivitas::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard';
    protected static ?string $navigationGroup = 'Cash Flow';
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('kendaraan_id')
                            ->label('Kendaraan')
                            ->relationship('kendaraan', 'plat_nomor')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('pengguna_id')
                            ->label('Pengguna')
                            ->relationship('pengguna', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required()
                            ->native(false) // Tambahkan ini untuk memastikan input tidak kosong
                            ->format('Y-m-d') // Pastikan format sesuai dengan database
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('kilometer_awal')
                            ->required()
                            ->prefix('KM')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('kilometer_akhir')
                            ->required()
                            ->prefix('KM')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('tujuan')
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('keterangan')
                            ->required()
                            ->columnSpan(2),
                    ])
                // Select::make('pengguna_id')
                //     ->label('Pengguna')
                //     ->relationship('pengguna', 'nama')
                //     ->required(),
                // DatePicker::make('tanggal')
                //     ->label('Tanggal')
                //     ->required(),
                // TextInput::make('kilometer_awal')
                //     ->label('Kilometer Awal')
                //     ->numeric()
                //     ->required(),
                // TextInput::make('kilometer_akhir')
                //     ->label('Kilometer Akhir')
                //     ->numeric()
                //     ->required(),
                // TextInput::make('tujuan')
                //     ->label('Tujuan')
                //     ->required(),
                // Textarea::make('keterangan')
                //     ->label('Keterangan')
                //     ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor')
                    ->sortable(),
                TextColumn::make('pengguna.nama')
                    ->label('Pengguna')
                    ->sortable(),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('kilometer_awal')
                    ->label('Kilometer Awal'),
                TextColumn::make('kilometer_akhir')
                    ->label('Kilometer Akhir'),
                TextColumn::make('tujuan')
                    ->label('Tujuan'),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
            ])
            ->filters([
                //
                SelectFilter::make('kendaraan_id')
                    ->label('Kendaraan')
                    ->relationship('kendaraan', 'plat_nomor'),
                SelectFilter::make('pengguna_id')
                    ->label('Pengguna')
                    ->relationship('pengguna', 'nama'),
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
            'index' => Pages\ListLogAktivitas::route('/'),
            'create' => Pages\CreateLogAktivitas::route('/create'),
            'edit' => Pages\EditLogAktivitas::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Penggunaan Kendaraan';
    }
}
