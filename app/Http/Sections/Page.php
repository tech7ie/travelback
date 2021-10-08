<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;
use Illuminate\Support\Facades\Auth;


/**
 * Class Page
 *
 * @property \App\Models\Page $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Page extends Section implements Initializable
{
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
    public function initialize()
    {
        $this->addToNavigation()->setPriority(101)->setIcon('fas fa-newspaper');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('title', 'Title', 'slug')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('title', 'like', '%'.$search.'%')
                        ->orWhere('lang', 'like', '%'.$search.'%');
                }),
//            AdminColumn::text('title', 'Slug', 'slug'),
            AdminColumn::text('lang', 'Language', 'lang'),
//            AdminColumn::text('author.name', 'Author'),
//            AdminColumn::datetime('created_at')->setLabel('Created')->setFormat('d.m.Y')
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false)
            ,
        ];

//        Page::select( 'lang' )->groupBy( 'lang' )->get()
        app()->getLocale();

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            null,null,
//            AdminColumnFilter::text()->setPlaceholder('Language'),
            AdminColumnFilter::select()
                ->setOptions(\Config::get('languages'))
//                ->setOptions(['en'=>"EN", 'de'=>"DE"])
//                ->setModelForOptions(\App\Models\Page::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('lang')
                ->setColumnName('lang')
                ->setPlaceholder('All Languages')
            ,
        ]);
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $tabs = AdminDisplay::tabbed();
        $form = AdminForm::card()->addBody(
            [
                AdminFormElement::columns()->addColumn(
                    [
                        AdminFormElement::hidden( 'user_id' )->setDefaultValue(Auth::id()),
                        AdminFormElement::text('slug', 'Slug')
                                        ->required(),
                        AdminFormElement::html('<hr>')
                    ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12')
            ]
        );


        $tabs->setTabs(function ($id) {
            $tabs = [];
            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn(
                    [
                        AdminFormElement::text('title_en', 'Title')
                                        ->required()
                        ,
                        AdminFormElement::html('<hr>')
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::text('meta_title_en', 'Meta title')
                                    ->required()
                    ,
                    AdminFormElement::text('meta_keywords_en', 'Meta keywords')
                                    ->required()
                    ,
                    AdminFormElement::textarea('meta_descriptions_en', 'Meta descriptions')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::wysiwyg('body_en', 'Content', 'ckeditor')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
            )->setLabel('EN');

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn(
                    [
                        AdminFormElement::text('title_de', 'Title')
                                        ->required()
                        ,
                        AdminFormElement::html('<hr>'),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::text('meta_title_de', 'Meta title')
                                    ->required()
                    ,
                    AdminFormElement::text('meta_keywords_de', 'Meta keywords')
                                    ->required()
                    ,
                    AdminFormElement::textarea('meta_descriptions_de', 'Meta descriptions')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::wysiwyg('body_de', 'Content', 'ckeditor')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
            )->setLabel('DE');

            $tabs[] = AdminDisplay::tab(
                AdminFormElement::columns()->addColumn(
                    [
                        AdminFormElement::text('title_pl', 'Title')
                                        ->required()
                        ,
                        AdminFormElement::html('<hr>'),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::text('meta_title_pl', 'Meta title')
                                    ->required()
                    ,
                    AdminFormElement::text('meta_keywords_pl', 'Meta keywords')
                                    ->required()
                    ,
                    AdminFormElement::textarea('meta_descriptions_pl', 'Meta descriptions')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
                addColumn([
                    AdminFormElement::wysiwyg('body_pl', 'Content', 'ckeditor')
                                    ->required()
                    ,
                ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
            )->setLabel('PL');

            return $tabs;
        });

//        $form = AdminForm::card()->addBody([
//            AdminFormElement::columns()->addColumn(
//                [
//                AdminFormElement::text('title', 'Title')
//                    ->required()
//                ,
//                AdminFormElement::text('slug', 'Slug')
//                    ->required()
//                ,
//                AdminFormElement::select('lang', 'Language', \Config::get('languages'))
//                    ->required()
//                ,
//                AdminFormElement::html('<hr>'),
//                AdminFormElement::datetime('created_at')
//                    ->setVisible(true)
//                    ->setReadonly(false)
//                ,
//            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
//            addColumn([
//                AdminFormElement::text('meta_title', 'Meta title')
//                                ->required()
//                ,
//                AdminFormElement::text('meta_keywords', 'Meta keywords')
//                                ->required()
//                ,
//                AdminFormElement::textarea('meta_descriptions', 'Meta descriptions')
//                                ->required()
//                ,
//            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->
//            addColumn([
//                AdminFormElement::wysiwyg('body', 'Content', 'ckeditor')
//                                ->required()
//                ,
//            ], 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
//        ]);



        $form->addHeader([
            $tabs
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
