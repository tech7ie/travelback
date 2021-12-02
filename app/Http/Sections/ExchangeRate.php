<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
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
 * @property \App\Models\ExchangeRate $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ExchangeRate extends Section implements Initializable {
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
            AdminColumn::link( 'currency', 'Currency', 'created_at' )
                       ->setSearchCallback( function ( $column, $query, $search ) {
                           return $query
                               ->orWhere( 'currency', 'like', '%' . $search . '%' )
                               ->orWhere( 'created_at', 'like', '%' . $search . '%' );
                       } )
                       ->setOrderable( function ( $query, $direction ) {
                           $query->orderBy( 'created_at', $direction );
                       } )
            ,
            AdminColumn::text( 'date', 'Date' ),
            AdminColumn::text( 'rate', 'Rate' ),
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

        $display->setColumnFilters( [
            AdminColumnFilter::select()
                             ->setModelForOptions( \App\Models\User::class, 'currency' )
                             ->setLoadOptionsQueryPreparer( function ( $element, $query ) {
                                 return $query;
                             } )
                             ->setDisplay( 'currency' )
                             ->setColumnName( 'currency' )
                             ->setPlaceholder( 'All currency' )
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


                AdminFormElement::select( 'currency', 'Country' )
                                ->setModelForOptions( \App\Models\Currency::class, 'currency' )
                                ->setUsageKey( 'currency' )
                                ->required(),
                AdminFormElement::text( 'rate', 'Rate' )
                                ->required()
                ,
                AdminFormElement::html( '<hr>' ),
                AdminFormElement::datetime( 'created_at' )
                                ->setVisible( true )
                                ->setReadonly( false )
                ,
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' ),
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
