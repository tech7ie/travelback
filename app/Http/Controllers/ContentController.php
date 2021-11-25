<?php

namespace App\Http\Controllers;

use App\Models\Content;

class ContentController {
    /**
     * The user repository instance.
     */
    protected $content;

    /**
     * Create a new controller instance.
     ** @return void
     */
    public function __construct() {
        $this->content = [];
    }

    /**
     * Show the user with the given ID.
     *
     * @param int $id
     */
    public function getContacts() {
        $contacts = Content::select()->whereIn( 'type', [ 'social', 'let_us_know', 'helpdesk' ]  )->get();
        $contacts_response = [];
        foreach ($contacts as $team){
            $contacts_response[] = [
                'label' => $this->getTranslateContent($team, 'label'),
                'body'              => strip_tags($this->getTranslateContent( $team, 'body' )),

//                'body' => $this->getTranslateContent($team, 'body'),
                'url' => $this->getTranslateContent($team, 'url'),
                'image' => $this->getTranslateContent($team, 'image'),
                'type' => $team['type']
            ];
        }



        $responseContact = [];
        foreach ($contacts_response as $contact){
            $responseContact[$contact['type']][] = $contact;
        }
        return $responseContact;
    }



    public function getTranslateContent($content, $key){
        return (isset($content[$key.'_'.app()->getLocale()]) && strlen($content[$key.'_'.app()->getLocale()]) > 0 ) ?$content[$key.'_'.app()->getLocale()] : $content[$key.'_en'];
    }
}
