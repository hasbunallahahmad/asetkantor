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

class ServisKendaraanRelationManager extends RelationManager
{
  protected static string $relationship = 'servisKendaraan';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\DatePicker::make('tanggal_servis')
          ->required()
          ->default(now()),
        Forms\Components\TextInput::make('jenis_servis')
          ->required()
          ->maxLength(100),
        Forms\Components\TextInput::make('kilometer_kendaraan')
          ->numeric()
          ->suffix('KM'),
        Forms\Components\TextInput::make('bengkel')
          ->maxLength(100),
        Forms\Components\TextInput::make('biaya')
          ->required()
          ->numeric()
          ->prefix('Rp'),
        Forms\Components\Textarea::make('keterangan')
          ->maxLength(65535)
          ->columnSpanFull(),
        Forms\Components\FileUpload::make('bukti_servis')
          ->directory('bukti-servis')
          ->visibility('public')
          ->acceptedFileTypes(['image/*', 'application/pdf'])
          ->maxSize(2048),
      ]);
  }
  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('jenis_servis')
      ->columns([
        Tables\Columns\TextColumn::make('tanggal_servis')
          ->date()
          ->sortable(),
        Tables\Columns\TextColumn::make('jenis_servis'),
        Tables\Columns\TextColumn::make('kilometer_kendaraan')
          ->suffix(' KM'),
        Tables\Columns\TextColumn::make('bengkel'),
        Tables\Columns\TextColumn::make('biaya')
          ->money('IDR')
          ->sortable(),
        Tables\Columns\TextColumn::make('keterangan')
          ->limit(50),
      ])
      ->filters([
        // Tambahkan filter jika diperlukan
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->after(function ($record, $data) {
            $kategoriId = KategoriPengeluaran::where('nama', 'Servis')->first()?->id;

            if (!$kategoriId) {
              $kategori = KategoriPengeluaran::create([
                'nama' => 'Servis',
                'keterangan' => 'Kategori untuk servis kendaraan'
              ]);
              $kategoriId = $kategori->id;
            }

            $pengeluaran = Pengeluaran::create([
              'kendaraan_id' => $record->kendaraan_id,
              'kategori_id' => $kategoriId,
              'tanggal' => $data['tanggal_servis'],
              'jumlah' => $data['biaya'],
              'keterangan' => $data['keterangan'] ?? 'Biaya servis kendaraan',
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
