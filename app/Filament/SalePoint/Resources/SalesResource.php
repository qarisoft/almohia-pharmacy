<?php

namespace App\Filament\SalePoint\Resources;

use App\Filament\SalePoint\Resources\SalesResource\Pages;
use App\Models\Products\MeasureUnit;
use App\Models\Products\Product;
use App\Models\Sales\SaleHeader;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SalesResource extends Resource
{
    protected static ?string $model = SaleHeader::class;

    public static function getLabel(): ?string
    {
        return __('Sales');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Sales');
    }


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('items')->label(__('items'))
                    ->relationship()
                    ->live()
                    ->collapsible()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        $price = 0;
                        foreach ($state as $priceItem) {
                            $product_id = $priceItem['product_id'];
                            if ($product_id) {
                                $quantity = $priceItem['quantity'];
                                $type = $priceItem['unit_id'];
                                $unit = MeasureUnit::query()->find($type);
                                if ($unit) {
                                    $p_price = $unit->sellPrice() * $quantity;
                                    $price += $p_price;
                                }
                            }
                        }
                        $discount = $get('discount');
                        $set('end_price', $price - intval($discount??0));
                    })
                    ->schema([
                        Select::make('product_id')
                            ->label(__('product'))
                            ->options(fn() => Product::query()->where('unit_price', '>', 0)->pluck('name_ar', 'id'))
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
//                                $p=Product::query()->find($state);
//                                $set('unit_id', $p->units()->first()->id);
//                                $set('end_price', 0);
//                                $set('cost_price', );
                            })
                            ->required()
                            ->autofocus(fn($operation) => $operation == 'create')
                            ->searchable()
                            ->columnSpan(3)
                            ->getSearchResultsUsing(fn($search) => Product::search($search)),

                        Select::make('unit_id')
                            ->label(__('unit'))
                            ->required()
                            ->live()
//                            ->native(false)
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                $q = intval($get('quantity')) ?? 1;
                                $unit = MeasureUnit::find($state);
                                if ($unit) {
                                    $set('end_price', intval($unit->sellPrice() * $q));
                                    $set('cost_price', intval($unit->costPrice() * $q));
                                }
                            })
                            ->options(function ($record, Get $get) {
                                $product_id = $get('product_id');

                                $product = Product::find($product_id);
                                if ($product) {
                                    return $product->units->pluck('name', 'id');
                                }
                                return [];
                            }),

                        TextInput::make('quantity')
                            ->label(__('quantity'))
                            ->numeric()
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                $unit = MeasureUnit::find($get('unit_id'));
                                if ($unit) {
                                    $set('end_price', intval($unit->sellPrice() * $state, 0));
                                }
                            })
                            ->default(1)
                            ->required()
                            ->columns(1),

                        TextInput::make('discount')
                            ->label(__('discount'))
                            ->numeric()
                            ->default(0),
                        TextInput::make('end_price')
                            ->label(__('price'))
                            ->numeric()
                            ->default(0),
                        TextInput::make('cost_price')
                            ->label(__('cost_price'))
                            ->numeric()
                            ->default(0)
                    ])->columns(8)
                    ->columnSpanFull(),

                Fieldset::make()->schema([

                    TextInput::make('discount')
                        ->label(__('discount'))
                        ->numeric()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                            $items = $get('items');
                            $price = 0;
                            foreach ($items as $item) {
                                $price = $price + $item['end_price'];
                            }
                            $set('end_price', $price - $state);
                        })
                        ->inlineLabel()
                        ->default(0),

                    TextInput::make('end_price')->inlineLabel()
                        ->label(__('end_price'))
                        ->numeric()
                        ->readOnly()
                        ->default(0),
                ])->columnSpan(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('end_price')->summarize(Tables\Columns\Summarizers\Sum::make('Sum')),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->default()
                    ->query(fn(Builder $query): Builder => $query->where('created_at', '>', today()->toDateString())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->persistFiltersInSession();
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'view' => Pages\ViewSales::route('/{record}'),
                        'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
