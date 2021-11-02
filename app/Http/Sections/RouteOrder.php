<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Cities;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class Country
 *
 * @property \App\Models\Country $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class RouteOrder extends Section implements Initializable {
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize() {
        $this->addToNavigation()->setPriority( 120 )->setIcon( 'fas fa-globe' );
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay( $payload = [] ) {
        $columns = [
            AdminColumn::text( 'id', '#' )->setWidth( '50px' )->setHtmlAttribute( 'class', 'text-center' ),
            AdminColumn::custom( 'Route', function ( $model ) {
                $route = $model->getRoute();
                return $route->title;
            } ),
            AdminColumn::custom( 'Vehicles', function ( $model ) {
                $cars = $model->getCars();
                $carsLists= [];
                $carsList = $cars->get();
                foreach ($carsList as $key => $car){
                    $carsLists[] = $car->title;
                }
                return implode(',', $carsLists);
            } ),
            AdminColumn::custom( 'Status', function ( $model ) {
                $color = $model->status === 'complete' ? 'green' : 'orange';
                return "<span style='color: ".$color."'>$model->status</span>";
            } ),
            AdminColumn::text( 'amount', 'Price' )
                       ->setOrderable( function ( $query, $direction ) {
                           $query->orderBy( 'status', $direction );
                       } )
                       ->setSearchable( false ),
            AdminColumn::text( 'created_at', 'Created / updated', 'updated_at' )
                       ->setOrderable( function ( $query, $direction ) {
                           $query->orderBy( 'updated_at', $direction );
                       } )
                       ->setSearchable( false )
            ,
        ];

        $display = AdminDisplay::datatables()
                               ->setName( 'firstdatatables' )
                               ->setOrder( [ [ 0, 'asc' ] ] )
                               ->setDisplaySearch( true )
                               ->paginate( 25 )
                               ->setColumns( $columns )
                               ->setHtmlAttribute( 'class', 'table-primary table-hover th-center' );

        $display->setColumnFilters( [
            AdminColumnFilter::select()
                             ->setModelForOptions( \App\Models\Country::class, 'name' )
                             ->setLoadOptionsQueryPreparer( function ( $element, $query ) {
                                 return $query;
                             } )
                             ->setDisplay( 'name' )
                             ->setColumnName( 'name' )
                             ->setPlaceholder( 'All names' )
            ,
        ] );
        $display->getColumnFilters()->setPlacement( 'card.heading' );

        return $display;
    }

    /**
     * @param int|null $id
     * @param array    $payload
     *
     * @return FormInterface
     */
    public function onEdit( $id = null, $payload = [] ) {
        $form = AdminForm::card()->addBody( [
            AdminFormElement::columns()->
            addColumn( [
                AdminFormElement::hidden( 'user_id' )->setDefaultValue( Auth::id() ),
                AdminFormElement::custom()
                                ->setDisplay(function($instance) {

                                    $route = $instance->getRoute();
                                    $title = $route['title'];
                                    $from = $instance->getCity($route['route_from_city_id'])['label'];
                                    $to = $instance->getCity($route['route_to_city_id'])['label'];
                                    return
                                        "
                                        <ul>
                                        <li>Route: ".json_encode($title)."</li>
                                        <li>From: $from</li>
                                        <li>To: $to</li>
                                        </ul>
                                     ";
                                })
                                ->setCallback(function($instance) {
                                }),
                AdminFormElement::text( 'first_name', 'First name' )->setReadonly(true),
                AdminFormElement::text( 'last_name', 'Last name' )->setReadonly(true),
                AdminFormElement::text( 'email', 'Email' )->setReadonly(true),
                AdminFormElement::text( 'phone', 'Phone' )->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->
            addColumn( [
                AdminFormElement::custom()
                                ->setDisplay(function($instance) {

                                    $places = $instance->places();
                                    $placesList = '';
                                    foreach ($places->get() as $place){
                                        $placesList .= "<li>". $place->title ." --- " . (int)$place->pivot->durations ."min.</li>";
                                    }
                                    return
                                        "<b>Places:</b>
                                        <ul>
                                        $placesList
                                        </ul>
                                     ";
                                })
                                ->setCallback(function($instance) {
                                }),
                AdminFormElement::custom()
                                ->setDisplay(function($instance) {


                                    $cars = $instance->getCars();
                                    $carsLists= '';
                                    $carsList = $cars->get();
                                    foreach ($carsList as $key => $car){
                                        $carsLists .= "<li>". $car->title ."</li>";

                                    }

                                    return
                                        "<b>Cars list:</b>
                                        <ul>
                                        $carsLists
                                        </ul>
                                     ";
                                })
                                ->setCallback(function($instance) {
                                }),
//                AdminFormElement::multiselect( 'places', 'Places' )
//                                ->setModelForOptions( \App\Models\Place::class, 'title' )
//                                ->required()->setReadonly(true),
//                AdminFormElement::multiselect( 'cars', 'Cars' )
//                                ->setModelForOptions( \App\Models\Car::class, 'brand' )
//                                ->required()->setReadonly(true),
                AdminFormElement::datetime( 'route_date', 'Route date' )
                                ->required(),
                AdminFormElement::columns()->
                addColumn(
                    [
                        AdminFormElement::text( 'adults', 'Adults' )
                                      ->required()
                    ],'col-xs-12 col-sm-6 col-md-4 col-lg-4')->
                addColumn(
                    [
                        AdminFormElement::text( 'childrens', 'Childrens' )
                                      ->required()
                    ],'col-xs-12 col-sm-6 col-md-4 col-lg-4')->
                addColumn(
                    [
                        AdminFormElement::text( 'luggage', 'Luggage' )
                                      ->required()
                    ],'col-xs-12 col-sm-6 col-md-4 col-lg-4'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->
            addColumn( [
                AdminFormElement::textarea( 'comment', 'Comment' )
                                ->required(),
                AdminFormElement::text( 'pickup_address', 'Pickup address' )
                                ->required(),
                AdminFormElement::text( 'drop_off_address', 'Drop off address' )
                                ->required(),
                AdminFormElement::number( 'amount', 'Amount')
                                ->required()->setReadonly(true),
                AdminFormElement::number( 'currency', 'Currency')
                                ->required()->setReadonly(true),
                AdminFormElement::custom()
                                ->setDisplay(function($instance) {

                                    $instance->payment_type;
                                    $payment_type = $instance->payment_type === 1 ? 'Cart' : 'Cash';
                                    return
                                        "<b>Payment type: ".$payment_type."</b>";
                                })
                                ->setCallback(function($instance) {
                                }),
                AdminFormElement::radio( 'status', 'Status' )
                                ->setOptions( [
                                    'pending'   => 'Pending',
                                    'complete' => 'Complete',
                                    'fail'   => 'Fail'
                                ] )
                                ->required()
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )
        ] );
        $form->getButtons()->setButtons( [
            'save'            => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create' => new SaveAndCreate(),
            'cancel'          => ( new Cancel() ),
        ] );

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate( $payload = [] ) {
        return $this->onEdit( null, $payload );
    }

    /**
     * @return bool
     */
    public function isDeletable( Model $model ) {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore( $id ) {
        // remove if unused
    }
}
