<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Auth::routes(['register'=> false]);

Route::get('/', 'HomeController@newsPaperIndex')->name('home');
Route::get('/news-paper-frame/{news_paper_frame_id}', 'HomeController@newsPaperIndexFrame')->name('frame');
Route::get('/{news_paper_id}/paper', 'HomeController@newsPaperIndex')->name('newsPaperIndex');

Route::post('/news-paper-page', 'HomeController@newsPaperPage')->name('newsPaperPageSingle');
Route::post('/news-paper-page_frame', 'HomeController@newsPaperPageFrame')->name('newsPaperPageFrameSingle');
Route::post('/news-paper-page_frames', 'HomeController@newsPaperPageFrames')->name('newsPaperPageFrames');
Route::view('about/nurul-alam', 'website.about.01');
Route::view('about/ruhul-amin', 'website.about.02');
Route::view('about/arif-sohel', 'website.about.03');

Route::group(['prefix'=> 'admin', 'middleware' => 'auth'], function(){

    Route::get('/', 'DashboardController@index')->name('dashboard.index');

    Route::get('news-paper/', 'NewsPaperController@index')->name('news-paper.index');
    Route::get('news-paper/create', 'NewsPaperController@create')->name('news-paper.create');
    Route::post('news-paper/store', 'NewsPaperController@store')->name('news-paper.store');
    Route::get('news-paper/edit/{id}', 'NewsPaperController@edit')->name('news-paper.edit');
    Route::post('news-paper/update', 'NewsPaperController@edit')->name('news-paper.update');
    Route::post('news-paper/delete/{id}', 'NewsPaperController@delete')->name('news-paper.delete');

    Route::post('news-paper/page-upload', 'NewsPaperController@pageUpload')->name('news-paper.page-upload');

    Route::get('news-paper/edit/news_paper_pages/{page_id}', 'NewsPaperPageController@edit')->name('news-paper-page.edit');

    Route::post('news-paper/update/news_paper_pages', 'NewsPaperPageController@update')->name('news-paper-page.update');

    Route::post('news-paper/update/news_paper_pages_frame', 'NewsPaperPageFrameController@update')->name('news-paper-page-frame.update');
});

Route::get('/mig', function(){
    $frames = \App\NewsPaperPage::where('image', 'not like', '%/%')->limit(500)->get();
    
    foreach ($frames as $frame) {
        $oldPath = "news_paper_pages/{$frame->image}";
        if (Storage::disk('public')->exists($oldPath) && strpos($frame->image, '/') === false) {
            $year = $frame->created_at->format('Y/m');
            $newPath = "{$year}/{$frame->image}";
            echo $newPath;

            \Storage::disk('public')->move("news_paper_pages/{$frame->image}", "news_paper_pages/{$newPath}");

            $frame->image = $newPath;
            $frame->save();

            // $this->info("Migrated {$frame->image}");
        }
    }
});