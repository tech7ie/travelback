<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\OurTeam;
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
                                            'title' => $content['title_'.app()->getLocale()],
                                            'body' => $content['body_'.app()->getLocale()],
                                            'meta_title' => $content['meta_title_'.app()->getLocale()],
                                            'meta_keywords' => $content['meta_keywords_'.app()->getLocale()],
                                            'meta_descriptions' => $content['meta_descriptions_'.app()->getLocale()],
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
                'title' => strlen($team['title_'.app()->getLocale()]) > 0 ? $team['title_'.app()->getLocale()] : $team['title'],
                'position' => strlen($team['position_'.app()->getLocale()]) > 0 ? $team['position_'.app()->getLocale()] : $team['position'],
                'body' => strlen($team['body_'.app()->getLocale()]) > 0 ? $team['body_'.app()->getLocale()] : $team['body'],
                'image' => $team['image']
            ];
        }

        return view( 'pages/about', ['content' =>
        [
            'slug' => $content['slug'],
            'title' => $content['title_'.app()->getLocale()],
            'body' => $content['body_'.app()->getLocale()],
            'meta_title' => $content['meta_title_'.app()->getLocale()],
            'meta_keywords' => $content['meta_keywords_'.app()->getLocale()],
            'meta_descriptions' => $content['meta_descriptions_'.app()->getLocale()],
            'team_response' => $team_response,

        ]] );
    }
}
