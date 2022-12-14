<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'showPrivacyPolicy']);
Route::get('/download', [App\Http\Controllers\HomeController::class, 'showDownloadPage']);


Route::post('/ajax/visit_log/save', [App\Http\Controllers\HomeController::class, 'saveVisitLog']);



Route::get('/admin/tom',  [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/admin/tom/visit_log/show',  [App\Http\Controllers\HomeController::class, 'showVisitLog']);
Route::get('/admin/tom/app_user_activity/show', [App\Http\Controllers\HomeController::class, 'showAppUserActivity']);

Route::get('/admin/tom/sentence/search', [App\Http\Controllers\AdminController::class, 'showSearchSentence']);
Route::post('/admin/ajax/senSearch', [App\Http\Controllers\AdminController::class, 'doSearchSentence']);

Route::get('/admin/tom/mobileapp/activity/show', [App\Http\Controllers\HomeController::class, 'showAppActivity']);
Route::get('/admin/tom/display_index/show',  [App\Http\Controllers\AdminController::class, 'showDisplayIndex']);
Route::post('/admin/ajax/display_index/search',  [App\Http\Controllers\AdminController::class, 'diIndexSearchWord']);
Route::post('/admin/ajax/display_index/re_assign',  [App\Http\Controllers\AdminController::class, 'diIndexReassign']);
Route::post('/admin/ajax/load_unused', [App\Http\Controllers\AdminController::class, 'loadUnusedWords']);
Route::post('/admin/ajax/fetch_word_by_bangla_meaning', [App\Http\Controllers\AdminController::class, 'fetchWOrdByBanglaMeaning']);


Route::post('/admin/ajax/save_word',  [App\Http\Controllers\AdminController::class, 'saveWord']);
Route::post('/admin/ajax/search-dword', [App\Http\Controllers\AdminController::class, 'searchDerivedWord']);
Route::post('/admin/ajax/search-syno-word', [App\Http\Controllers\AdminController::class, 'searchSynonymWord']);
Route::post('/admin/ajax/take-discard-syno', [App\Http\Controllers\AdminController::class, 'takeOrDiscardSynonym']);
Route::post('/admin/ajax/fetch-meanings', [App\Http\Controllers\AdminController::class, 'fetchMeanings']);
Route::post('/admin/ajax/search-anto-word',  [App\Http\Controllers\AdminController::class, 'searchAntonymWord']);
Route::post('/admin/ajax/save_word_category', [App\Http\Controllers\AdminController::class, 'saveWordCategory']);
Route::match(array('GET', 'POST'), '/admin/ajax/fetch_word', [App\Http\Controllers\AdminController::class, 'fetchWordDetails']);



Route::get('/test/cam', [App\Http\Controllers\TestSampleController::class, 'cambridgeWordsBulkInsert']);
Route::get('/test/saw', 'TestSampleController@synAntWebster');
Route::get('/test/bn', 'TestSampleController@extractBanglaContainingText');
Route::get('/test/tns', 'TestSampleController@epizy2localTransfer');
Route::get('/test/t', 'TestSampleController@test');
Route::post('/test/t/ajax', 'TestSampleController@testAjax');
Route::get('/test/insertTestCategories', 'TestSampleController@insertTestCategories');
Route::get('/test/insertDerived', 'TestSampleController@insertDerivedWords');
Route::get('/test/insertMnemonics', 'TestSampleController@insertMnemonics');
Route::get('/test/prevW', 'TestSampleController@exportPrevWords');
Route::get('/test/dropbox', 'TestSampleController@dropboxTest');
Route::get('/test/backup/db', 'TestSampleController@dbBackup');
Route::get('/test/backup/dropbox', [App\Http\Controllers\TestSampleController::class, 'saveToDropbox']);



Route::get('/test/rearrangeUses', 'TestSampleController@rearrangeUses');
Route::get('/test/wmEnlist', 'TestSampleController@wordsmartButNotListedAsMain');
Route::get('/test/meriCollingsInsert', 'TestSampleController@merriamCollingsDefinitionExampleInsert');

Route::get('/scrap/ds', 'WebScrapperController@dailyStarScrapper');
Route::get('/scrap/t', 'WebScrapperController@t');
Route::get('/scrapper/news/insert', 'WebScrapperController@insertNews');



Route::match( array('GET', 'POST'), '/chat/insert/userMsg', [App\Http\Controllers\ChatController::class, 'insertMsgFromUser']);
Route::match( array('GET', 'POST'), '/chat/insert/adminMsg',  [App\Http\Controllers\ChatController::class, 'insertMsgFromAdmin']);
Route::match(array('GET', 'POST'), '/chat/get-data', [App\Http\Controllers\ChatController::class, 'fetchChatData']);




Route::match(array('GET', 'POST'), '/notific/push/check', [App\Http\Controllers\NotificationController::class, 'checkAvailability']);
Route::get('/admin/notific/',  [App\Http\Controllers\NotificationController::class, 'showCreateNotification']);
Route::match(['GET', 'POST'], '/admin/notific/create', [App\Http\Controllers\NotificationController::class, 'doCreateNotification']);


Route::get('/admin/tom/chat/user/all', [App\Http\Controllers\ChatController::class, 'showUsersList']);
Route::get('/admin/tom/chat/user', [App\Http\Controllers\ChatController::class, 'showChatPage']);



Route::get('/exam/gen', [App\Http\Controllers\ExamController::class, 'generateQuestions']);
Route::get('/exam/gen/insert', [App\Http\Controllers\ExamController::class, 'insertQuestions']);
Route::get('/student/exam', [App\Http\Controllers\ExamController::class, 'index']);
Route::get('/student/exam/result', [App\Http\Controllers\ExamController::class, 'showResult']);
Route::get('/student/exam/result/{testId}',  [App\Http\Controllers\ExamController::class, 'showSingleResult']);
Route::post('/student/exam/ajax/fetch_question',  [App\Http\Controllers\ExamController::class, 'fetchQuestion']);
Route::post('/student/exam/ajax/submit_answer',  [App\Http\Controllers\ExamController::class, 'submitAnswer']);
Route::post('/student/exam/ajax/fetch_result',  [App\Http\Controllers\ExamController::class, 'fetchResult']);



Route::get('/api/mobile', [App\Http\Controllers\ApiController::class, 'fetchWordData']);
Route::match( array('GET', 'POST'), '/api/mobile/log/save',  [App\Http\Controllers\ApiController::class, 'saveAppLog']);
Route::match( array('GET', 'POST'), '/api/mobile/register', [App\Http\Controllers\ApiController::class, 'registerDevice']);
Route::get('/api/mobile/exportForAndroid',  [App\Http\Controllers\ApiController::class, 'prepareWordsForAndroid']);



Route::match( array('GET', 'POST'), '/api/payment/create', [App\Http\Controllers\UserPaymentController::class, 'insertPayment']);
Route::match( array('GET', 'POST'), '/api/payment/verify',  [App\Http\Controllers\UserPaymentController::class, 'verifyPayment']);

Route::match( ['GET', 'POST'], '/api/coupon/verify',  [App\Http\Controllers\UserPaymentController::class, 'verifyCoupon']);


Auth::routes();

Route::get('/home', function (){
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//as url takes optional parameter, so it has been written at last sothat it doesn't conflict with other urls
Route::get('/{ref?}/{refName?}', [App\Http\Controllers\HomeController::class, 'index']); //check for reference url