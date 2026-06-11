<?php

namespace App\Http\Controllers;

use App\NewsPaperPage;
use App\NewsPaperPageFrame;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class NewsPaperPageFrameController extends Controller
{
    public function update(Request $request)
    {
        if($request->hasFile('image')){
            $year = date('Y');
            $month = date('m');

            // Create directory path: storage/app/public/news_paper_pages/{year}/{month}
            $save_path = storage_path("app/public/news_paper_pages/{$year}/{$month}");

            // Make sure the directory exists
            if (!file_exists($save_path)) {
                mkdir($save_path, 0755, true);
            }

            $news_paper_page = NewsPaperPage::with('newsPaper')->find($request->news_paper_page_id);

            $image_name = $news_paper_page->newsPaper->id.'-'.$request->news_paper_page_id.'-'.$request->frame_id.'-'.time().'.jpg';

            Image::make($request->file('image'))
                ->encode('jpg', 75)
                ->save($save_path.'/'.$image_name, 60);

            $news_paper_page_frame = NewsPaperPageFrame::where('unique_id', $request->frame_id)->first();

            if(!$news_paper_page_frame){
                $news_paper_page_frame = new NewsPaperPageFrame();
            }

            $news_paper_page_frame->news_paper_page_id = $request->news_paper_page_id;
            $news_paper_page_frame->unique_id = $request->frame_id;
            $news_paper_page_frame->title = $request->title;
            $news_paper_page_frame->details = $request->details;
            $news_paper_page_frame->image = "{$year}/{$month}/{$image_name}";
            if($request->hasFile('details_image')){
                $details_image_name = $news_paper_page->newsPaper->id.'-'.$request->news_paper_page_id.'-'.$request->frame_id.'-details-'.time().'.jpg';
    
                Image::make($request->file('details_image'))
                    ->encode('jpg', 75)
                    ->save($save_path.'/'.$details_image_name, 60);
    
                $news_paper_page_frame->details_image = "{$year}/{$month}/{$details_image_name}";
            }
            $news_paper_page_frame->save();
        }
    }
}
