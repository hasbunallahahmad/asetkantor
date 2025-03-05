<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServisKendaraanResource\Pages;
use App\Filament\Resources\ServisKendaraanResource\RelationManagers;
use App\Models\ServisKendaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServisKendaraanResource extends Resource
{
    protected static ?string $model = ServisKendaraan::class;

    protected static ?string $navigationIcon = 'heroicon-c-cog';
    protected static ?string $navigationGroup = 'Cash Flow';
    protected static ?int $navigationSort = 6;

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return false; // Menu tidak akan muncul di sidebar
    // }

    public static function getNavigationLabel(): string
    {
        return 'Servis Kendaraan';
    }

    public static function getPluralLabel(): string
    {
        return 'Servis Kendaraan';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kendaraan')
                    ->schema([
                        Forms\Components\Select::make('kendaraan_id')
                            ->label('Kendaraan')
                            ->relationship('kendaraan', 'plat_nomor')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Detail Servis')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_servis')
                            ->required()
                            ->label('Tanggal Servis')
                            ->default(now()),

                        Forms\Components\TextInput::make('jenis_servis')
                            ->required()
                            ->maxLength(100)
                            ->label('Jenis Servis'),

                        Forms\Components\TextInput::make('kilometer_kendaraan')
                            ->numeric()
                            ->prefix('KM')
                            ->label('Kilometer Kendaraan'),

                        Forms\Components\TextInput::make('bengkel')
                            ->maxLength(100)
                            ->label('Bengkel'),
                    ]),

                Forms\Components\Section::make('Informasi Biaya')
                    ->schema([
                        Forms\Components\TextInput::make('biaya')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Biaya')
                            ->default(0),

                        Forms\Components\Select::make('pengeluaran_id')
                            ->relationship('pengeluaran', 'id')
                            ->searchable()
                            ->preload()
                            ->label('Pengeluaran ID')
                            ->placeholder('Pilih Pengeluaran (Opsional)'),
                    ]),

                Forms\Components\Section::make('Keterangan Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('ID')
                //     ->sortable()
                //     ->searchable(),

                Tables\Columns\TextColumn::make('kendaraan.plat_nomor')
                    ->label('Nomor Plat')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_servis')
                    ->label('Tanggal Servis')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_servis')
                    ->label('Jenis Servis')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('kilometer_kendaraan')
                    ->label('Kilometer')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bengkel')
                    ->label('Bengkel')
                    ->limit(20)
                    ->searchable(),

                Tables\Columns\TextColumn::make('biaya')
                    ->label('Biaya')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kendaraan_id')
                    ->relationship('kendaraan', 'plat_nomor')
                    ->label('Kendaraan')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('tanggal_servis')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_dari')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('tanggal_sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_dari'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_servis', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_sampai'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_servis', '<=', $date),
                            );
                    }),

                Tables\Filters\Filter::make('biaya')
                    ->form([
                        Forms\Components\TextInput::make('biaya_dari')
                            ->label('Biaya Minimal')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('biaya_sampai')
                            ->label('Biaya Maksimal')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['biaya_dari'],
                                fn(Builder $query, $amount): Builder => $query->where('biaya', '>=', $amount),
                            )
                            ->when(
                                $data['biaya_sampai'],
                                fn(Builder $query, $amount): Builder => $query->where('biaya', '<=', $amount),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),


            ])
            ->defaultSort('tanggal_servis', 'desc');
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
            'index' => Pages\ListServisKendaraans::route('/'),
            'create' => Pages\CreateServisKendaraan::route('/create'),
            'edit' => Pages\EditServisKendaraan::route('/{record}/edit'),
            'view' => Pages\ViewServisKendaraan::route('/{record}'),
        ];
    }
}
