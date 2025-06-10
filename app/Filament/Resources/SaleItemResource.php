<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleItemResource\Pages;
//use App\Filament\Resources\SaleItemResource\RelationManagers;
//use App\Models\SaleItem;
use App\Models\Products\MeasureUnit;
use App\Models\Sales\SaleItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleItemResource extends Resource
{
    protected static ?string $model = SaleItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('product.name_ar'),
                TextColumn::make('unit.name'),
                TextColumn::make('quantity'),
                TextColumn::make('end_price')->label('sell')->summarize(Tables\Columns\Summarizers\Sum::make('Sum')),
                TextColumn::make('cost')->state(fn(SaleItem $record)=>$record->costPrice()),
                TextColumn::make('profit')->summarize(Tables\Columns\Summarizers\Sum::make('Sum')),
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
            'index' => Pages\ListSaleItems::route('/'),
            'create' => Pages\CreateSaleItem::route('/create'),
            'edit' => Pages\EditSaleItem::route('/{record}/edit'),
        ];
    }
}
