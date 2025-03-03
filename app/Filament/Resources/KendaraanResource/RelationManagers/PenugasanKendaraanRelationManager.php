<?php
// app/Filament/Resources/KendaraanResource/RelationManagers/PenugasanKendaraanRelationManager.php
namespace App\Filament\Resources\KendaraanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PenugasanKendaraanRelationManager extends RelationManager
{
  protected static string $relationship = 'penugasanKendaraan';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('pengguna_id')
          ->relationship('pengguna', 'nama')
          ->required()
          ->searchable()
          ->preload(),
        Forms\Components\DatePicker::make('tanggal_mulai')
          ->required(),
        Forms\Components\DatePicker::make('tanggal_selesai'),
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
        Tables\Columns\TextColumn::make('pengguna.nama'),
        Tables\Columns\TextColumn::make('tanggal_mulai')
          ->date(),
        Tables\Columns\TextColumn::make('tanggal_selesai')
          ->date()
          ->placeholder('Masih Berlangsung'),
        Tables\Columns\TextColumn::make('keterangan')
          ->limit(50),
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
