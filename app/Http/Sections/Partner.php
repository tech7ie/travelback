<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

/**
 * Class Country
 *
 * @property \App\Models\Country $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Partner extends Section implements Initializable {
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
            AdminColumn::custom( 'Status', function ( $model ) {
                $color = $model->status === 'enabled' ? 'green' : 'red';
                return "<span style='color: ".$color."'>$model->status</span>";
            } ),
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
                AdminFormElement::text( 'url', 'Url' ),
                AdminFormElement::radio( 'status', 'Status' )
                                ->setEnum( [ 'enabled', 'disabled' ] )
                                ->required(),
                AdminFormElement::html( '<hr>' ),
            ], 'col-xs-12 col-sm-12 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::wysiwyg( 'body', 'Descriptions' ),
                AdminFormElement::html( '<hr>' ),
            ], 'col-xs-12 col-sm-12 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::image( 'image', 'Image' )
                    ->setAfterSaveCallback(function ($value, $model) {
                        if ($value) {
                            $map = collect($value)->map(function ($item) {
                                ImageOptimizer::optimize($item);
                            });
                            $map = collect($value)->map(function ($item) {
                                $pathinfo = pathinfo($item);
//  ( [dirname] => images/uploads
// [basename] => 16446f607e0947a19243e9c2bc9f88b5.jpg
// [extension] => jpg
// [filename] => 16446f607e0947a19243e9c2bc9f88b5 )
                                $pathinfo['basename'] = '274x118_' . $pathinfo['basename'];
                                $resized_image = $pathinfo['dirname'] . '/' . $pathinfo['basename'];
                                $img = Image::make($item);
                                $img->resize(274, 118, function ($const) {
                                    $const->aspectRatio();
                                })->save($resized_image);
                            });
                        }
                    })
                ,
                AdminFormElement::html( '<hr>' ),
            ], 'col-xs-12 col-sm-12 col-md-4 col-lg-4' ),
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
