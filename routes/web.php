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




Route::get('/partner', [App\Http\Controllers\AffiliateController::class, 'showAffiliateHome']);
Route::get('/partner/proposal', [App\Http\Controllers\AffiliateController::class, 'showAffiliateLandingPage']);
Route::get('/partner/terms-of-service', [App\Http\Controllers\AffiliateController::class, 'showTermsOfService']);



Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'showPrivacyPolicy']);
Route::get('/download', [App\Http\Controllers\HomeController::class, 'showDownloadPage']);
Route::get('/download/pdf', [App\Http\Controllers\HomeController::class, 'showPdfDownload']);


Route::post('/ajax/visit_log/save', [App\Http\Controllers\HomeController::class, 'saveVisitLog']);



Route::post('/ajax/post_link/save', [\App\Http\Controllers\AffiliateController::class, 'savePostLink']);




Route::get('/admin/tom/affiliate/all', [\App\Http\Controllers\AdminAffiliateManageController::class, 'index']);
Route::get('/admin/tom/affiliate/id/{id}/show', [\App\Http\Controllers\AdminAffiliateManageController::class, 'showIndividual']);




Route::get('/admin/tom',  [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/admin/tom/visit_log/show',  [App\Http\Controllers\HomeController::class, 'showVisitLog']);
Route::get('/admin/tom/app_user_activity/show', [App\Http\Controllers\HomeController::class, 'showAppUserActivity']);
Route::get('/admin/tom/affiliate_approval/show', [App\Http\Controllers\AdminController::class, 'showAffiliateApprovalPage']);

Route::get('/admin/tom/pdf/generate/export-words', [\App\Http\Controllers\AdminController::class, 'exportWordsPdf']);


Route::post('/admin/tom/ajax/post/send_approval_mail', [\App\Http\Controllers\AdminController::class, 'sendApprovalMail']);


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
Route::get('/test/tns', [App\Http\Controllers\TestSampleController::class, 'questionBankAddMeanings']);
Route::get('/test/t', 'TestSampleController@test');
Route::post('/test/t/ajax', 'TestSampleController@testAjax');
Route::get('/test/insertTestCategories', 'TestSampleController@insertTestCategories');
Route::get('/test/insertDerived', 'TestSampleController@insertDerivedWords');
Route::get('/test/insertMnemonics', 'TestSampleController@insertMnemonics');
Route::get('/test/prevW', [App\Http\Controllers\TestSampleController::class, 'exportPrevWords']);
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



//Route::get('/api/mobile', [App\Http\Controllers\ApiController::class, 'fetchWordData']);
Route::match( array('GET', 'POST'), '/api/mobile/log/save',  [App\Http\Controllers\ApiController::class, 'saveAppLog']);
Route::match( array('GET', 'POST'), '/api/mobile/register', [App\Http\Controllers\ApiController::class, 'registerDevice']);

Route::match( array('GET', 'POST'), '/api/payment/create', [App\Http\Controllers\UserPaymentController::class, 'insertPayment']);
Route::match( array('GET', 'POST'), '/api/user/payment/verification_status',  [App\Http\Controllers\UserPaymentController::class, 'verificationStatus']);

Route::get('/api/fb_group/jovoc/post', [App\Http\Controllers\TestSampleController::class, 'postInfbPageJobVocabulary']);





/************ Word import export for mobile app ******************/

Route::get('/mobile/exportForAndroid',  [App\Http\Controllers\Processor\AppReadyDataExporter::class, 'prepareWordsForAndroid']);

Route::get('/question_bank/data/import/banks/prev_year_questions', [App\Http\Controllers\Processor\AppReadyDataExporter::class, 'importPrevYearQuestions']);

/* Previous year question bank export */
Route::get('/mobile_app/data/export/prev_year_questions', [App\Http\Controllers\Processor\AppReadyDataExporter::class, 'exportPrevYearQuestions']);

/************ Word import export ******************/




Route::get('/buy/app',  [App\Http\Controllers\UserPaymentController::class, 'showBuyApp']);
Route::post('/buy/app/payment/verify',  [App\Http\Controllers\UserPaymentController::class, 'verifyPayment']);
Route::get('/buy/app/payment/issue/report/show',  [App\Http\Controllers\UserPaymentController::class, 'verifyPaymentIssueReport']);

Route::match( ['GET', 'POST'], '/api/coupon/verify',  [App\Http\Controllers\UserPaymentController::class, 'verifyCoupon']);


Auth::routes();




//as url takes optional parameter, so it has been written at last so that it doesn't conflict with other urls
Route::get('/p/{referenceName?}', [App\Http\Controllers\HomeController::class, 'index']); //check for reference url

Route::get('/home', function (){
    return view('home');
});