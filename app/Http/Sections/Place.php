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
 * Class Users
 *
 * @property \App\Models\User $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Place extends Section implements Initializable {

    /**
     * @var string
     */
    protected $createTitle = "Create Content";

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
        $this->addToNavigation()->setPriority( 150 )->setIcon( 'fas fa-users' );
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay( $payload = [] ) {
        $columns = [
            AdminColumn::text( 'id', '#' )->setWidth( '50px' )->setHtmlAttribute( 'class', 'text-center' ),
            AdminColumn::link( 'title', 'Title', 'created_at' )
                       ->setSearchCallback( function ( $column, $query, $search ) {
                           return $query
                               ->orWhere( 'label', 'like', '%' . $search . '%' )
                               ->orWhere( 'type', 'like', '%' . $search . '%' );
                       } )
                       ->setOrderable( function ( $query, $direction ) {
                           $query->orderBy( 'created_at', $direction );
                       } )
            ,
            AdminColumn::text( 'price', 'Price' ),
            AdminColumn::text( 'durations', 'Durations' ),
            AdminColumn::text( 'created_at', 'Created / updated', 'updated_at' )
                       ->setWidth( '160px' )
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

//        $display->setColumnFilters( [
//            AdminColumnFilter::select()
//                             ->setOptions( [
//                                 'social'      => 'social',
//                                 'let_us_know' => 'let_us_know',
//                                 'helpdesk'    => 'helpdesk'
//                             ] )
//                             ->setLoadOptionsQueryPreparer( function ( $element, $query ) {
//                                 return $query;
//                             } )
//                             ->setDisplay( 'type' )
//                             ->setColumnName( 'type' )
//                             ->setPlaceholder( 'All types' )
//            ,
//        ] );
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

        $tabs = AdminDisplay::tabbed();


//        $form = AdminForm::card();
        $form = AdminForm::card()->addBody( [
            AdminFormElement::columns()->addColumn( [
                AdminFormElement::hidden( 'user_id' )->setDefaultValue(Auth::id()),
                AdminFormElement::selectajax( 'country_id', 'Country' )
                                ->setModelForOptions( Country::class, 'name' )
                                ->required(),
                AdminFormElement::dependentselect( 'city_id', 'City' )
                                ->setModelForOptions( Cities::class, 'name' )
                                ->setDataDepends( [ 'country_id' ] )
                                ->setLoadOptionsQueryPreparer( function ( $item, $query ) {
                                    return $query->where( 'country_id', $item->getDependValue( 'country_id' ) );
                                } )
                                ->required(),
                AdminFormElement::number( 'price', 'Price' )
                                ->required(),
                AdminFormElement::number( 'price_per_hour', 'Price extra (hour)' )
                                ->required(),
                AdminFormElement::number( 'durations', 'Durations' )
                                ->required(),
                AdminFormElement::number( 'extra_durations', 'Extra durations' )
                                ->required(),
                AdminFormElement::radio( 'status', 'Status' )
                                ->setOptions( [ 'enabled' => 'Enabled', 'disabled' => 'Disabled' ] )
                                ->required(),

                AdminFormElement::text( 'url', 'Url' ),
                AdminFormElement::html( '<hr>' ),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::image( 'image', 'Image' ),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' ),
        ] );

        $tabs->setTabs( function ( $id ) {
            $tabs = [];

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn( [
                    AdminFormElement::text( 'title', 'Title' )
                                    ->required(),
                    AdminFormElement::html( '<hr>' ),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                    AdminFormElement::wysiwyg( 'body', 'Content', 'ckeditor' )
                                    ->required(),
                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' )
            )->setLabel( 'EN' );

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn( [
                    AdminFormElement::text( 'title_de', 'Title' ),
                    AdminFormElement::html( '<hr>' ),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                    AdminFormElement::wysiwyg( 'body_de', 'Content', 'ckeditor' ),
                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' )
            )->setLabel( 'DE' );

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn( [
                    AdminFormElement::text( 'title_pl', 'Title' ),
                    AdminFormElement::html( '<hr>' ),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                    AdminFormElement::wysiwyg( 'body_pl', 'Content', 'ckeditor' ),
                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' )
            )->setLabel( 'PL' );

            return $tabs;
        } );


        $form->addHeader( [
            $tabs
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
