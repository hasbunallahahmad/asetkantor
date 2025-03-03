<?php

namespace App\Filament\Resources\KendaraanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PengeluaranRelationManager extends RelationManager
{
  protected static string $relationship = 'pengeluaran';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('kategori_id')
          ->relationship('kategori', 'nama')
          ->required()
          ->searchable()
          ->preload()
          ->live()
          ->afterStateUpdated(function (Forms\Set $set, $state) {
            $set('created_by', Auth::id());
          }),
        Forms\Components\DatePicker::make('tanggal')
          ->required()
          ->default(now()),
        Forms\Components\TextInput::make('jumlah')
          ->required()
          ->numeric()
          ->prefix('Rp'),
        Forms\Components\FileUpload::make('bukti_pembayaran')
          ->directory('bukti-pembayaran')
          ->acceptedFileTypes(['image/*', 'application/pdf'])
          ->maxSize(2048),
        Forms\Components\Hidden::make('created_by')
          ->required()
          ->default(fn() => 1), // Ganti dengan ID pengguna aktif sesuai sistem auth
        Forms\Components\Textarea::make('keterangan')
          ->maxLength(65535)
          ->columnSpanFull(),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('id')
      ->columns([
        Tables\Columns\TextColumn::make('kategori.nama'),
        Tables\Columns\TextColumn::make('tanggal')
          ->date(),
        Tables\Columns\TextColumn::make('jumlah')
          ->money('IDR')
          ->sortable(),
        Tables\Columns\TextColumn::make('createdBy.nama')
          ->label('Dibuat Oleh'),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make(),
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
