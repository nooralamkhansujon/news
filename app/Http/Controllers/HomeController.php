<?php

namespace App\Http\Controllers;

use App\NewsPaper;
use App\NewsPaperPage;
use App\NewsPaperPageFrame;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    public function newsPaperPageFrames(Request $request)
    {
        $news_paper_page = NewsPaperPage::with('newsPaperPageFrames')->find($request->news_paper_page_id);
        
        if ($news_paper_page) {
            // Return only frames that have images, keyed by unique_id
            $frames = $news_paper_page->newsPaperPageFrames->filter(function($frame) {
                return !empty($frame->image);
            })->keyBy('unique_id');
            
            return $frames;
        }

        return [];
    }


    public function newsPaperIndex($news_paper_id='')
    {
        if($news_paper_id==''){
            $news_paper = NewsPaper::latest()->first();
        }else{
            $news_paper = NewsPaper::where('publish_date', $news_paper_id)->first();
        }

        return view('website.news_paper', compact('news_paper'));
    }
    
    public function newsPaperIndexFrame($news_paper_frame_id, Request $request)
    {
        $news_paper_page_frame = NewsPaperPageFrame::where('unique_id', $request->news_paper_frame_id)->first();

        return view('website.news_paper_frame', compact('news_paper_page_frame'));
    }

    public function newsPaperPage(Request $request)
    {
        $news_paper_page = NewsPaperPage::find($request->news_paper_page_id);

        return $news_paper_page;
    }

    public function newsPaperPageFrame(Request $request)
    {
        $news_paper_page_frame = NewsPaperPageFrame::where('unique_id', $request->frame_id)->first();

        return $news_paper_page_frame;
    }
}
