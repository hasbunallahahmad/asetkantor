<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KendaraanResource\Pages;
use App\Filament\Resources\KendaraanResource\RelationManagers as RelationManagers;
use App\Models\Kendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KendaraanResource extends Resource
{
    protected static ?string $model = Kendaraan::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Data Kendaraan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('jenis_kendaraan_id')
                            ->relationship('jenisKendaraan', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('merk')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('model')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('plat_nomor')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('nomor_mesin')
                            ->maxLength(50)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('nomor_rangka')
                            ->maxLength(50)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('tahun_pengadaan')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y'))
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('anggaran_tahunan')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->columnSpan(1),
                        Forms\Components\DatePicker::make('tanggal_pajak_tahunan')
                            ->columnSpan(1),
                        Forms\Components\DatePicker::make('tanggal_stnk_habis')
                            ->columnSpan(1),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Dalam Perbaikan' => 'Dalam Perbaikan',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])
                            ->default('Aktif')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('plat_nomor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisKendaraan.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_pengadaan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('anggaran_tahunan')
                    ->money('IDR')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('tanggal_pajak_tahunan')
                //     ->date()
                //     ->sortable()
                //     ->color(
                //         fn(Kendaraan $record) =>
                //         $record->tanggal_pajak_tahunan && $record->tanggal_pajak_tahunan->isPast()
                //             ? 'danger'
                //             : ($record->tanggal_pajak_tahunan && $record->tanggal_pajak_tahunan->diffInDays(now()) < 30
                //                 ? 'warning'
                //                 : 'success')
                //     ),
                // Tables\Columns\TextColumn::make('tanggal_stnk_habis')
                //     ->date()
                //     ->sortable()
                //     ->color(
                //         fn(Kendaraan $record) =>
                //         $record->tanggal_stnk_habis && $record->tanggal_stnk_habis->isPast()
                //             ? 'danger'
                //             : ($record->tanggal_stnk_habis && $record->tanggal_stnk_habis->diffInDays(now()) < 30
                //                 ? 'warning'
                //                 : 'success')
                // ),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Dalam Perbaikan' => 'warning',
                        'Tidak Aktif' => 'danger',
                    }),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('jenis_kendaraan')
                    ->relationship('jenisKendaraan', 'nama'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Dalam Perbaikan' => 'Dalam Perbaikan',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),
                Tables\Filters\Filter::make('pajak_expired')
                    ->label('Pajak Jatuh Tempo')
                    ->query(fn(Builder $query): Builder => $query->whereDate('tanggal_pajak_tahunan', '<', now())),
                Tables\Filters\Filter::make('pajak_soon')
                    ->label('Pajak Segera Jatuh Tempo')
                    ->query(fn(Builder $query): Builder => $query->whereDate('tanggal_pajak_tahunan', '>=', now())
                        ->whereDate('tanggal_pajak_tahunan', '<=', now()->addDays(30))),
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
            RelationManagers\PenugasanKendaraanRelationManager::class,
            RelationManagers\PengeluaranRelationManager::class,
            RelationManagers\PembelianBensinRelationManager::class,
            RelationManagers\ServisKendaraanRelationManager::class,
            RelationManagers\PembayaranStnkRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKendaraans::route('/'),
            'create' => Pages\CreateKendaraan::route('/create'),
            'edit' => Pages\EditKendaraan::route('/{record}/edit'),
        ];
    }
}
