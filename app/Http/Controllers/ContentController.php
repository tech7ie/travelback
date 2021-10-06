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
//        return $contacts;

        $responseContact = [];
        foreach ($contacts as $contact){
            $responseContact[$contact['type']][] = $contact;
        }
        return $responseContact;
    }
}
