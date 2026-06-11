<?php

namespace App\Http\Controllers;

use App\NewsPaperPage;
use Illuminate\Http\Request;

class NewsPaperPageController extends Controller
{
    public function edit($page_id)
    {
        $news_paper_pages = NewsPaperPage::find($page_id);

        return view('admin.news_paper_pages.edit', compact('news_paper_pages'));
    }

    public function update(Request $request)
    {
        $news_paper_page = NewsPaperPage::find($request->frameId);

        $news_paper_page->map_data_json = $request->mapDataJson;
        $news_paper_page->map_data_area = $request->mapDataArea;
        
        $news_paper_page->save();
    }
}
