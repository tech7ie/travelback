<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\OurTeam;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagePost extends Controller
{


    /**
     * Show Pages.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index( \Illuminate\Http\Request $request ) {
        $page = explode('/',  $request->path())[1];
        $content = Page::query()->where([['slug', '=', $page]])->first() ?? false;

        return view( 'pages/page', ['content' =>
                                        [
                                            'slug' => $content['slug'],
                                            'title' => $this->getTranslateContent($content, 'title'),
                                            'body' => $this->getTranslateContent($content, 'body'),
                                            'meta_title' => $this->getTranslateContent($content, 'meta_title'),
                                            'meta_keywords' => $this->getTranslateContent($content, 'meta_keywords'),
                                            'meta_descriptions' => $this->getTranslateContent($content, 'meta_descriptions')
                                        ]] );
    }


    /**
     * Show about page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function about( \Illuminate\Http\Request $request ) {
        $content = Page::query()->where([['slug', '=', 'about']])->first() ?? false;
        $our_team = OurTeam::query()->where('status', '=', 'enabled')->get();
        $team_response = [];
        foreach ($our_team as $team){
            $team_response[] = [
                'title' => $this->getTranslateContent($team, 'title'),
                'position' => $this->getTranslateContent($team, 'position'),
                'body' => $this->getTranslateContent($team, 'body'),
                'image' => $team['image']
            ];
        }

        return view( 'pages/about', ['content' =>
        [
            'slug' => $content['slug'],
            'title' => $this->getTranslateContent($content, 'title'),
            'body' => $this->getTranslateContent($content, 'body'),
            'meta_title' => $this->getTranslateContent($content, 'meta_title'),
            'meta_keywords' => $this->getTranslateContent($content, 'meta_keywords'),
            'meta_descriptions' => $this->getTranslateContent($content, 'meta_descriptions'),
            'team_response' => $team_response,

        ]] );
    }

    public function getTranslateContent($content, $key){
        return (isset($content[$key.'_'.app()->getLocale()]) && strlen($content[$key.'_'.app()->getLocale()]) > 0 ) ?$content[$key.'_'.app()->getLocale()] : $content[$key.'_en'];
    }
}
