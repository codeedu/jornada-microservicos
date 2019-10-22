<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Order';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make("Customer")->searchable(),
            Select::make("Status")->options([
               'Reservado'=>'Reservado',
               'Aguardando Retirada'=>'Aguardando Retirada',
               'Entregue'=>'Entregue',
               'Concluido'=>'Concluído'
            ]),
            Currency::make("Downpayment")->hideFromIndex(),
            Currency::make("Delivery fee",'delivery_fee')->hideFromIndex(),
            Currency::make("Late fee",'late_fee')->hideFromIndex(),
            Currency::make("Discount")->hideFromIndex(),
            Date::make("Reservation date","order_date"),
            Date::make("Return date","return_date"),
            Currency::make("Total")->readonly(),
            Currency::make("Balance")->readonly(),
            HasMany::make("Items","items","App\Nova\OrderItem")->hideFromIndex(),
            HasMany::make("Payments")->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
