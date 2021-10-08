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
class Routes extends Section implements Initializable {
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
            AdminColumn::link( 'title', 'Name', 'created_at' )
                       ->setSearchCallback( function ( $column, $query, $search ) {
                           return $query
                               ->orWhere( 'title', 'like', '%' . $search . '%' )
                               ->orWhere( 'created_at', 'like', '%' . $search . '%' );
                       } )
            ,
            AdminColumn::text( 'status', 'Status' )
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
            AdminFormElement::columns()->addColumn( [
                AdminFormElement::hidden( 'user_id' )->setDefaultValue(Auth::id()),
                AdminFormElement::text( 'title', 'Name' ),
                AdminFormElement::multiselect( 'cars', 'Car' )
                                ->setModelForOptions( \App\Models\Car::class, 'title' )
                                ->required()
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::selectajax( 'route_from_country_id', 'From' )
                                ->setModelForOptions( Country::class, 'name' )
                                ->required(),
                AdminFormElement::dependentselect( 'route_from_city_id', 'From City' )
                                ->setModelForOptions( Cities::class, 'name' )
                                ->setDataDepends( [ 'route_from_country_id' ] )
                                ->setLoadOptionsQueryPreparer( function ( $item, $query ) {
                                    return $query->where( 'country_id', $item->getDependValue( 'route_from_country_id' ) );
                                } )
                                ->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::selectajax( 'route_to_country_id', 'To' )
                                ->setModelForOptions( Country::class, 'name' )
                                ->required(),
                AdminFormElement::dependentselect( 'route_to_city_id', 'To City' )
                                ->setModelForOptions( Cities::class, 'name' )
                                ->setDataDepends( [ 'route_to_country_id' ] )
                                ->setLoadOptionsQueryPreparer( function ( $item, $query ) {
                                    return $query->where( 'country_id', $item->getDependValue( 'route_to_country_id' ) );
                                } )
                                ->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::datetime( 'route_start', 'Route start' )
                                ->required(),
                AdminFormElement::datetime( 'route_end', 'Route start' )
                                ->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::text( 'price', 'Price' )
                                ->required(),
                AdminFormElement::radio( 'status', 'Status' )
                                ->setOptions( [ 'open' =>'open', 'closed'=>'closed', 'done'=>'done', 'fail'=>'fail' ] )
                                ->required()
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::image( 'image', 'Image' )
                                ->required()
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::multiselect( 'places', 'Places' )
                                ->setModelForOptions( \App\Models\Place::class, 'title' )
                                ->required(),
//                AdminFormElement::manyToMany( 'points', [
//                ] )
//                                ->setRelatedElementDisplayName( function ( $model ) {
//                                    return $model->name . ', ' . $model->country_code;
//                                } )
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::wysiwyg('body', 'Content', 'ckeditor')
                                ->required()
            ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12' )
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
