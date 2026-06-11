<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsPaper;
use App\NewsPaperPage;
use App\NewsPaperPageFrame;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class NewsPaperController extends Controller
{

    public function index()
    {
        $news_papers = NewsPaper::orderBy('publish_date', 'DESC')->paginate();

        return view('admin.news_paper.index', compact('news_papers'));
    }

    public function create()
    {
        return view('admin.news_paper.create');
    }

    public function store(Request $request)
    {
        $news_paper = new NewsPaper();
        $news_paper->publish_date = $request->publish_date;
        $news_paper->save();

        return redirect()->route('news-paper.edit', $news_paper->id);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $news_paper = NewsPaper::with('newsPaperPages')->find($id);

        return view('admin.news_paper.edit', compact('news_paper'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function pageUpload(Request $request)
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

            $image_name = time().'.jpg';
            Image::make($request->file('image'))
                ->resize(1012, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 75)
                ->save($save_path.'/'.$image_name, 60);

            $news_paper_pages = new NewsPaperPage();
            $news_paper_pages->news_paper_id = $request->news_paper_id;
            $news_paper_pages->title = 'title';
            $news_paper_pages->image = "{$year}/{$month}/{$image_name}";
            $news_paper_pages->map_data_json = '{"version":"1.1.10","map":{"width":1012,"height":1451,"areas":[],"name":"90789789","hasDefaultArea":false,"dArea":{"shape":"default","coords":[],"href":"","title":"","id":0,"iMap":"90789789","isDefault":true},"lastId":0}}';

            $news_paper_pages->save();

            return $news_paper_pages;
        }

        return false;
    }

    public function delete($id)
    {
        $save_path = storage_path('app/public/news_paper_pages');

        $news_paper = NewsPaper::find($id);

        foreach($news_paper->newsPaperPages as $newsPaperPages){
            
            $NewsPaperPageFrame = NewsPaperPageFrame::where('news_paper_page_id', $newsPaperPages->id)->get();

            foreach($NewsPaperPageFrame as $frame){
                if(File::exists($save_path.'/'.$frame->image)){
                    File::delete($save_path.'/'.$frame->image);
                }

                $frame->delete();
            }

            if(File::exists($save_path.'/'.$newsPaperPages->image)){
                File::delete($save_path.'/'.$newsPaperPages->image);
            }

        }

        $news_paper->newsPaperPages()->delete();

        $news_paper->delete();

        return redirect()->back();
    }
}
