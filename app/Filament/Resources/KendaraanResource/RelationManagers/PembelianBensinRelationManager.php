<?php

namespace App\Filament\Resources\KendaraanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriPengeluaran;
use App\Models\Pengeluaran;

class PembelianBensinRelationManager extends RelationManager
{
  protected static string $relationship = 'pembelianBensin';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\DatePicker::make('tanggal_beli')
          ->required()
          ->default(now()),
        Forms\Components\TextInput::make('jumlah_liter')
          ->numeric()
          ->suffix('Liter'),
        Forms\Components\TextInput::make('harga_per_liter')
          ->numeric()
          ->prefix('Rp'),
        Forms\Components\TextInput::make('total_biaya')
          ->required()
          ->numeric()
          ->prefix('Rp'),
        Forms\Components\TextInput::make('kilometer_kendaraan')
          ->numeric()
          ->suffix('KM'),
        Forms\Components\Textarea::make('keterangan')
          ->maxLength(65535)
          ->columnSpanFull(),
        Forms\Components\FileUpload::make('bukti_pembelian')
          ->directory('bukti-bensin')
          ->visibility('public')
          ->acceptedFileTypes(['image/*', 'application/pdf'])
          ->maxSize(2048),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('id')
      ->columns([
        Tables\Columns\TextColumn::make('tanggal_beli')
          ->date(),
        Tables\Columns\TextColumn::make('jumlah_liter')
          ->suffix(' Liter')
          ->numeric(2),
        Tables\Columns\TextColumn::make('harga_per_liter')
          ->money('IDR'),
        Tables\Columns\TextColumn::make('total_biaya')
          ->money('IDR')
          ->sortable(),
        Tables\Columns\TextColumn::make('kilometer_kendaraan')
          ->suffix(' KM'),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->after(function ($record, $data) {
            // Buat entri pengeluaran untuk pembelian bensin ini
            $kategoriId = KategoriPengeluaran::where('nama', 'Bensin')->first()?->id;

            if (!$kategoriId) {
              $kategori = KategoriPengeluaran::create([
                'nama' => 'Bensin',
                'keterangan' => 'Kategori untuk pembelian bensin kendaraan'
              ]);
              $kategoriId = $kategori->id;
            }

            $pengeluaran = Pengeluaran::create([
              'kendaraan_id' => $record->kendaraan_id,
              'kategori_id' => $kategoriId,
              'tanggal' => $data['tanggal_beli'],
              'jumlah' => $data['total_biaya'],
              'keterangan' => $data['keterangan'] ?? 'Pembelian bensin',
              'created_by' => Auth::id() ?? 1,
            ]);

            $record->update(['pengeluaran_id' => $pengeluaran->id]);
          }),
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
}
