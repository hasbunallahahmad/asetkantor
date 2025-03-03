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
use Illuminate\Database\Eloquent\Model;



class PembayaranStnkRelationManager extends RelationManager
{
  protected static string $relationship = 'pembayaranStnk';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\DatePicker::make('tanggal_pembayaran')
          ->required()
          ->default(now()),
        Forms\Components\TextInput::make('nominal')
          ->required()
          ->numeric()
          ->prefix('Rp'),
        Forms\Components\TextInput::make('masa_berlaku')
          ->required()
          ->numeric()
          ->suffix(' Tahun'),
        Forms\Components\Textarea::make('keterangan')
          ->maxLength(65535)
          ->columnSpanFull(),
        Forms\Components\FileUpload::make('bukti_pembayaran')
          ->directory('bukti-stnk')
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
        Tables\Columns\TextColumn::make('tanggal_pembayaran')
          ->date(),
        Tables\Columns\TextColumn::make('nominal')
          ->money('IDR')
          ->sortable(),
        Tables\Columns\TextColumn::make('masa_berlaku')
          ->suffix(' Tahun'),
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->after(function ($record, $data) {
            $kategoriId = KategoriPengeluaran::where('nama', 'Pembayaran STNK')->first()?->id;
            if (!$kategoriId) {
              $kategori = KategoriPengeluaran::create([
                'nama' => 'Pembayaran STNK',
                'keterangan' => 'Kategori untuk pembayaran STNK kendaraan'
              ]);
              $kategoriId = $kategori->id;
            }

            $pengeluaran = Pengeluaran::create([
              'kendaraan_id' => $record->kendaraan_id,
              'kategori_id' => $kategoriId,
              'tanggal' => $data['tanggal_pembayaran'],
              'jumlah' => $data['nominal'],
              'keterangan' => $data['keterangan'] ?? 'Pembayaran STNK',
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

  // public static function canViewForRecord($ownerRecord): bool
  // {
  //   return request()->routeIs('filament.admin.resources.kendaraans.view');
  // }
}
