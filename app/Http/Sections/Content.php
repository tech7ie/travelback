<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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
 * @property \App\Models\User $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Content extends Section implements Initializable {

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
            AdminColumn::link( 'label', 'Label', 'created_at' )
                       ->setSearchCallback( function ( $column, $query, $search ) {
                           return $query
                               ->orWhere( 'label', 'like', '%' . $search . '%' )
                               ->orWhere( 'type', 'like', '%' . $search . '%' );
                       } )
                       ->setOrderable( function ( $query, $direction ) {
                           $query->orderBy( 'created_at', $direction );
                       } )
            ,
            AdminColumn::text( 'type', 'Type' ),
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
                             ->setOptions( [
                                 'social'      => 'social',
                                 'let_us_know' => 'let_us_know',
                                 'helpdesk'    => 'helpdesk'
                             ] )
                             ->setLoadOptionsQueryPreparer( function ( $element, $query ) {
                                 return $query;
                             } )
                             ->setDisplay( 'type' )
                             ->setColumnName( 'type' )
                             ->setPlaceholder( 'All types' )
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

        $tabs = AdminDisplay::tabbed();


        $form = AdminForm::card();
        $form1 = AdminForm::card()->addBody( [
            AdminFormElement::columns()->addColumn( [
                AdminFormElement::text( 'label', 'Label' )
                                ->required(),
                AdminFormElement::select( 'type', 'Type', [
                    'social'      => 'social',
                    'let_us_know' => 'let_us_know',
                    'helpdesk'    => 'helpdesk'
                ] )->required(),
                AdminFormElement::text( 'url', 'Url' )
                                ->required(),
                //                AdminFormElement::html( '<hr>' ),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::wysiwyg( 'body', 'Content', 'ckeditor' )
                                ->required(),
                AdminFormElement::image( 'image', 'Image' ),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' ),
        ] );

        $tabs->setTabs(function ($id) {
            $tabs = [];

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn( [
                    AdminFormElement::text( 'label', 'Label' )
                                    ->required(),
                    AdminFormElement::select( 'type', 'Type', [
                        'social'      => 'social',
                        'let_us_know' => 'let_us_know',
                        'helpdesk'    => 'helpdesk'
                    ] )->required(),
                    AdminFormElement::text( 'url', 'Url' )
                                    ->required(),
                    //                AdminFormElement::html( '<hr>' ),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                    AdminFormElement::wysiwyg( 'body', 'Content', 'ckeditor' )
                                    ->required(),
                    AdminFormElement::image( 'image', 'Image' ),
                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' ),
            )->setLabel('EN');

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn( [
                    AdminFormElement::text( 'label', 'Label' )
                                    ->required(),
                    AdminFormElement::select( 'type', 'Type', [
                        'social'      => 'social',
                        'let_us_know' => 'let_us_know',
                        'helpdesk'    => 'helpdesk'
                    ] )->required(),
                    AdminFormElement::text( 'url', 'Url' )
                                    ->required(),
                    //                AdminFormElement::html( '<hr>' ),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                    AdminFormElement::wysiwyg( 'body_de', 'Content', 'ckeditor' )
                                    ->required(),
                    AdminFormElement::image( 'image', 'Image' ),
                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8' )
            )->setLabel('DE');

            return $tabs;
        });


        $form->addHeader([
            $tabs
        ]);

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
