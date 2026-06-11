<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPaperController;
use App\Http\Controllers\NewsPaperPageController;
use App\Http\Controllers\NewsPaperPageFrameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Auth::routes(['register' => false]);

Route::get('/', [HomeController::class, 'newsPaperIndex'])->name('home');
Route::get('/news-paper-frame/{news_paper_frame_id}', [HomeController::class, 'newsPaperIndexFrame'])->name('frame');
Route::get('/{news_paper_id}/paper', [HomeController::class, 'newsPaperIndex'])->name('newsPaperIndex');

Route::post('/news-paper-page', [HomeController::class, 'newsPaperPage'])->name('newsPaperPageSingle');
Route::post('/news-paper-page_frame', [HomeController::class, 'newsPaperPageFrame'])->name('newsPaperPageFrameSingle');
Route::post('/news-paper-page_frames', [HomeController::class, 'newsPaperPageFrames'])->name('newsPaperPageFrames');
Route::view('about/nurul-alam', 'website.about.01');
Route::view('about/ruhul-amin', 'website.about.02');
Route::view('about/arif-sohel', 'website.about.03');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('news-paper/', [NewsPaperController::class, 'index'])->name('news-paper.index');
    Route::get('news-paper/create', [NewsPaperController::class, 'create'])->name('news-paper.create');
    Route::post('news-paper/store', [NewsPaperController::class, 'store'])->name('news-paper.store');
    Route::get('news-paper/edit/{id}', [NewsPaperController::class, 'edit'])->name('news-paper.edit');
    Route::post('news-paper/update', [NewsPaperController::class, 'edit'])->name('news-paper.update');
    Route::post('news-paper/delete/{id}', [NewsPaperController::class, 'delete'])->name('news-paper.delete');

    Route::post('news-paper/page-upload', [NewsPaperController::class, 'pageUpload'])->name('news-paper.page-upload');

    Route::get('news-paper/edit/news_paper_pages/{page_id}', [NewsPaperPageController::class, 'edit'])->name('news-paper-page.edit');

    Route::post('news-paper/update/news_paper_pages', [NewsPaperPageController::class, 'update'])->name('news-paper-page.update');

    Route::post('news-paper/update/news_paper_pages_frame', [NewsPaperPageFrameController::class, 'update'])->name('news-paper-page-frame.update');
});

Route::get('/mig', function () {
    $frames = \App\NewsPaperPage::where('image', 'not like', '%/%')->limit(500)->get();

    foreach ($frames as $frame) {
        $oldPath = "news_paper_pages/{$frame->image}";
        if (Storage::disk('public')->exists($oldPath) && strpos($frame->image, '/') === false) {
            $year = $frame->created_at->format('Y/m');
            $newPath = "{$year}/{$frame->image}";
            echo $newPath;

            Storage::disk('public')->move("news_paper_pages/{$frame->image}", "news_paper_pages/{$newPath}");

            $frame->image = $newPath;
            $frame->save();
        }
    }
});
