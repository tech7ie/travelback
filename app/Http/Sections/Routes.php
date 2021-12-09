<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Cities;
use App\Models\Country;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;
//use Spatie\ImageOptimizer\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

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

            AdminColumn::custom( 'From', function ( $model ) {
                $city = $model->getFromCity();

                return $city[0]->name;
            } ),
            AdminColumn::custom( 'to', function ( $model ) {
                $city = $model->getToCity();

                return $city[0]->name;
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
                AdminFormElement::hidden( 'user_id' )->setDefaultValue( Auth::id() ),
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
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->
//            addColumn( [
//                AdminFormElement::datetime( 'route_start', 'Route start' )
//                                ->required(),
//                AdminFormElement::datetime( 'route_end', 'Route start' )
//                                ->required(),
//            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->
            addColumn( [
                AdminFormElement::text( 'price', 'Price €' )
                                ->required(),
                AdminFormElement::radio( 'status', 'Status' )
                                ->setEnum( [
                                    'open'   => 'open',
                                    'closed' => 'closed',
//                                    'done'   => 'done',
//                                    'fail'   => 'fail'
                                ] )
                                ->required()
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::image( 'image', 'Image' )
                                ->required()
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
                                $pathinfo['basename'] = '404x309_' . $pathinfo['basename'];
                                $resized_image = $pathinfo['dirname'] . '/' . $pathinfo['basename'];
                                $img = Image::make($item);
                                $img->resize(404, 309, function ($const) {
                                    $const->aspectRatio();
                                })->save($resized_image);
                            });
                        }
                    })
//                    ->setAfterSaveCallback(function ($value, $model) {
//                        if ($value) {
//                            $map = collect($value)->map(function ($item) {
//                                ImageOptimizer::optimize($item);
////                                return str_replace(config('filesystems.disks.s3.bucket_url'), "", $item);
//                            });
//
////                            $model->moderated_images()->delete();
//
////                            $images = Image::whereIn('image_path', $map)->pluck('image_path', 'id');
////                            foreach ($images as $id => $image) {
////                                $data = ['image_id' => $id, 'image_path' => $image, 'moderated' => 1];
////
////                                $model->related_image($data, Auth::user());
////                            }
//                        }
//                    })
//                    ->setSaveCallback(function ($file, $path, $filename, $settings) use ($id) {
//
//                                    die($path);
//                        ImageOptimizer::optimize($path);
//                        return parent::saveFile($file, $path, $filename, $settings);
//
////                        return ['path' => $result['url'], 'value' => $result['url']];
//                    })
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::multiselect( 'places', 'Places' )
                                ->setModelForOptions( \App\Models\Place::class, 'title_en' )
                                ->required(),
                //                AdminFormElement::manyToMany( 'points', [
                //                ] )
                //                                ->setRelatedElementDisplayName( function ( $model ) {
                //                                    return $model->name . ', ' . $model->country_code;
                //                                } )
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4' )->addColumn( [
                AdminFormElement::wysiwyg( 'body', 'Content', 'ckeditor' )
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
        return false;
    }

    /**
     * @return void
     */
    public function onRestore( $id ) {
        // remove if unused
    }
}
