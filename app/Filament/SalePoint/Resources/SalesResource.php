<?php

namespace App\Filament\SalePoint\Resources;

use App\Filament\SalePoint\Resources\SalesResource\Pages;

//use App\Filament\SalePoint\Resources\SalesResource\RelationManagers;
//use App\Models\Sales;
use App\Models\Products\MeasureUnitName;
use App\Models\Products\Product;
use App\Models\Sales\SaleHeader;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\Repeater::make('items')->label(__('items'))
                    ->relationship()
                    ->live()
                    ->collapsible()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        $price = 0;
                        foreach ($state as $priceItem) {
                            $product_id = $priceItem['product_id'];
                            $quantity = $priceItem['quantity'];
                            $type = $priceItem['type'] ?? 1;
                            if ($type) {
                                $product = Product::find($product_id);
                                if ($product) {
                                    $p_price = $product->unit_price * $quantity * $type;
                                    $price += $p_price;
                                }
                            }
                        }
                        $discount = $get('discount');
                        $set('end_price', $price - $discount);
                    })
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label(__('product'))
                            ->options(fn() => Product::query()->where('unit_price', '>', 0)->pluck('name_ar', 'id'))
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {

                                $set('end_price', Product::find($state)->unit_price);
                                $set('type', 1);
                            })
                            ->required()
                            ->autofocus(fn($operation) => $operation == 'create')
                            ->searchable()
                            ->columnSpan(3)
                            ->getSearchResultsUsing(fn($search) => Product::search($search)),

                        Select::make('type')
                            ->required()
                            ->live()
                            ->preload()
                            ->native(false)
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                $q = $get('quantity');
                                $product_id = $get('product_id');
                                if ($product_id) {
                                    $product = Product::find($product_id);
                                    $set('end_price', $product->unit_price * $state * $q);
                                }
                            })
                            ->options(function ($record, Get $get) {
                                $product_id = $get('product_id');

                                if ($product_id) {
                                    $product = Product::find($product_id);
                                    return $product->units->pluck('name', 'count');
                                }
                                return [];
                            }),

                        TextInput::make('quantity')
                            ->label(__('quantity'))
                            ->numeric()
                            ->live(debounce: 500)
                            ->required()
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                $type_count = $get('type');
                                $factor = 1;
                                if ($type_count) {
                                    $factor = $type_count;
                                }
                                $product_id = $get('product_id');
                                if ($product_id) {
                                    $product = Product::find($product_id);
                                    $set('end_price', $product->unit_price * $state * $factor);
                                }
                            })
                            ->default(1)
                            ->required()
                            ->columns(1),


                        Forms\Components\TextInput::make('end_price')
                            ->label(__('price'))
                            ->numeric()
                            ->readOnly()
                            ->default(0)
                    ])->columns(6)
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make()->schema([

                    TextInput::make('discount')
                        ->label(__('discount'))
                        ->numeric()
                        ->live(onBlur: true,debounce: 1000)
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
                Tables\Columns\TextColumn::make('end_price'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->defaultSort('id','desc')
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->default()
                    ->query(fn (Builder $query): Builder => $query->where('created_at','>', today()->toDateString())),
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
//            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
