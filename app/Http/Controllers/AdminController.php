<?php

namespace App\Http\Controllers;

use App\Models\AffiliatePersons;
use App\Models\AffiliatePosts;
use App\Models\Antonyms;
use App\Models\DerivedWords;
use App\Models\DontConfuseWith;
use App\Models\Meanings;
use App\Models\Mnemonics;
use App\Models\Notes;
use App\Models\PartsOfSpeech;
use App\Models\Synonyms;
use App\Models\WordCategories;
use App\Models\Words;
use App\Models\WordUsages;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use function Psr\Log\error;
use function Ramsey\Uuid\Generator\timestamp;

//use Kreait\Firebase;
//use Kreait\Firebase\Factory;
//use Kreait\Firebase\ServiceAccount;


class AdminController extends Controller
{
    private $minimalView = false;

    function __construct(){
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            if(! in_array(Auth::id(), MyConstants::$adminIds)){
                abort(403);
            }

            return $next($request);
        });
    }


    public function index(){
        //return $this->extractSynonymWords(12);

        $partsOfSpeechAndOtherForms = ["noun", "pronoun", "adjective", "verb", "adverb", "preposition", "conjunction", "interjection", "phrasal verb", "past", "pp", "past + pp"];
        $partsOfSpeech = $partsOfSpeechAndOtherForms;

        $wordCategories = MyConstants::$WORD_CATEGORIES;

        return view('admin/index', compact(
            'partsOfSpeech', 'wordCategories'
        ));
    }


    public function showAffiliateApprovalPage(Request $request){

        /* testing purpose
        $data = [
            'appName'   => env('APP_NAME'),
            'userName'  => 'Shakil Ahmed',
            'msg'       => "We saw that you created a nice video. Below we have provided you an affiliate link which you will put in the description of your video. When someone buys from your link, you will get the revenue share.",
            'affiliateLink' => 'http://jovoc.com?p=yt643kj'
        ];
        return view('mailPages.approve_post_mail', compact('data')); //just test
         testing purpose */

        $posts = DB::table('users as u')
            ->select('u.id as uid', 'u.name', 'u.email', 'p.id as postId', 'p.post_link as postLink', 'p.created_at')
            ->join('affiliate_posts as p', 'u.id', 'p.user_id')
            ->where('approved', 0)
            ->get();

        $emailMsg = MyConstants::$affiliatePostApproveEmailTemplate;
        //this message which might be edited by admin before sending

        return view('admin.affiliate_approval', compact('posts', 'emailMsg'));
    }

    public function approvePost(Request $request){
        $result = AffiliatePosts::where('id', $request->postId)
            ->update(['approved'=>1]);
        return $result;
    }


    private function createAffiliateLink($userId){
        $row = AffiliatePersons::where('user_id', $userId)->select('reference_token')->get();
        if(count($row) > 0){
            $token = $row[0]->reference_token;
            return env('BASE_DOMAIN').'?p='.$token;
        }

        return "ERROR occured. Please contact support !"; //very unlikely case. token should have been existed.
    }

    public function sendApprovalMail(Request $request){
        $userId = $request->userId;
        $row = AffiliatePersons::where('user_id', $userId)->select('reference_token')->get();
        if(count($row) == 0){
            //new affiliate. so create their reference token
            $person = new AffiliatePersons();
            $person->user_id = $userId;
            $person->reference_token = (new Library())->forgeAffiliateToken($userId);
            $person->created_at = Carbon::now();
            $person->updated_at = Carbon::now();
            $person->save();
        }

        $data = [
            'appName'   => env('APP_NAME'),
            'userName'  => $request->userName,
            'mailTo'    => $request->email, //affiliate email
            'adminEmail'=> config('values.adminEmail'),
            'msg'       => $request->msg,
            'subject'   => MyConstants::$affiliatePostApproveMailSubject,
            'affiliateLink' => $this->createAffiliateLink($userId)
        ];

        try{
            Mail::send('mailPages.approve_post_mail', ['data'=>$data], function ($m) use ($data){
                $m->from($data['adminEmail']);
                $m->to($data['mailTo'])->subject($data['subject']);
            });
        }catch (Exception $exception){
            return $exception;
        }

        $result = $this->approvePost($request);
        if($result == 1){
            return 'ok';
        }
    }



    public function saveWord(Request $request){
        //return $request->all();

        $word = Words::where('word', $request->base_word)->get();
        $baseWord = $request->base_word;

        if(count($word) > 0){
            //word exist, so update all data pertaining it
            //return $request->all();

            $wordObj = Words::firstOrNew(['id'=>$word[0]->id]);
            $wordObj->word = $word[0]->word;
            $wordObj->importance_level = $request->importance_level;
            $wordObj->pronunciation = $request->pronunciation;
            $wordObj->is_base_word = $request->base_or_derived[0];
            $wordObj->is_derived_word = $request->base_or_derived[1];
            $wordObj->updated_at = Carbon::now();
            $wordObj->save();

            $actionData['word'] = $wordObj;


            if($request->bangla_meaning){
                foreach ($request->bangla_meaning as $row){
                    if( isset($row['meaning_id']) && isset($row['bangla_meaning'])){
                        //meaning exist, update it
                        Meanings::where('id', $row['meaning_id'])
                            ->update(['bangla_meaning' => $row['bangla_meaning']]);
                    }
                    if( ! isset($row['meaning_id']) && isset($row['bangla_meaning'])){
                        //new meaning , insert it
                        Meanings::create([
                            'word_id'           => $word[0]->id,
                            'bangla_meaning'    => $row['bangla_meaning'],
                            'created_at'        => Carbon::now(),
                            'updated_at'        => Carbon::now()
                        ]);
                    }
                    if( isset($row['meaning_id']) && ! isset($row['bangla_meaning']) ){
                        //user intends to keep it blank, i.e. delete it
                        Meanings::where('id', $row['meaning_id'])->delete();
                    }
                }
            }
            $meanings = Meanings::where('word_id', $word[0]->id)
                ->get(['id', 'bangla_meaning']);
            $actionData['meanings'] = $meanings;


            $actionData['checked_categories'] = $this->checkedCategories($word[0]->id);
            

            foreach ($request->parts_of_speech as $pof){
                if( isset($pof['pof_id']) && isset($pof['pof_val']) ){
                    //existing , update it
                    PartsOfSpeech::where(['id'=>$pof['pof_id']])
                        ->update([ 'parts_of_speech'=>$pof['pof_val'] ]);
                }
                if( isset($pof['pof_id']) && ! isset($pof['pof_val']) ){
                    /* user intends to keep it blank. To set null value */
                    PartsOfSpeech::where(['id'=>$pof['pof_id']])
                        ->update([ 'parts_of_speech'=>null ]);
                }
                if( ! isset($pof['pof_id']) && isset($pof['pof_val']) ){
                    //new data, insert it
                    $inserted = PartsOfSpeech::create([
                        'word_id'           => $word[0]->id,
                        'parts_of_speech'   => $pof['pof_val'],
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now()
                    ]);
                }
            }

            $partsOfSpeech = PartsOfSpeech::where('word_id', $word[0]->id)->get(['id', 'parts_of_speech']);
            if(count($partsOfSpeech)>0){
                $actionData['parts_of_speech'] = $partsOfSpeech;
            }


            $mnemonic = Mnemonics::firstOrNew(['word_id'=>$word[0]->id]);
            $mnemonic->mnemonic = $request->mnemonic;
            $mnemonic->updated_at = Carbon::now();
            $mnemonic->save();

            $note = Notes::firstOrNew(['word_id'=>$word[0]->id]);
            $note->word_note = $request->word_note;
            $note->mnemonic_note = $request->mnemonic_note;
            $note->derivation_note = $request->derivation_note;
            $note->synonym_note = $request->synonym_note;
            $note->antonym_note = $request->antonym_note;
            $note->usage_note = $request->usage_note;
            $note->updated_at = Carbon::now();
            $note->save();

            $notes = Notes::where('word_id', $word[0]->id)->get();
            if(count($notes)>0){
                $actionData['notes'] = $notes;
            }


            $dontConfuseWith = DontConfuseWith::firstOrNew(['word_id'=>$word[0]->id]);
            $dontConfuseWith->hint = $request->confusing_hint;
            $dontConfuseWith->updated_at = Carbon::now();
            $dontConfuseWith->save();

            $confusing = DontConfuseWith::where('word_id', $word[0]->id)->get();
            if(count($confusing)>0){
                $actionData['confusing'] = $confusing;
            }




            if(! $this->minimalView){
                if( isset($request->derived_words) ){
                    //return $request->derived_words;
                    foreach ($request->derived_words as $dword){
                        if( isset($dword['dword_id']) && ! isset($dword['dword']) ){
                            //intentionally kept blank, so delete it
                            DerivedWords::where('word_id', $word[0]->id)
                                ->where('derived_word_id', $dword['dword_id'])
                                ->delete();
                        }else{
                            $dword['how_related'] = is_null($dword['how_related']) ? "":$dword['how_related'];
                            $dw = DerivedWords::where('word_id', $word[0]->id)
                                ->where('derived_word_id', $dword['dword_id'])
                                ->get(['id']);
                            if(count($dw)>0){
                                //exists, so update it
                                DerivedWords::where('word_id', $word[0]->id)
                                    ->where('derived_word_id', $dword['dword_id'])
                                    ->update(['how_related'=>$dword['how_related'] ]);
                            }else{
                                DerivedWords::create([
                                    'word_id'           => $word[0]->id,
                                    'derived_word_id'   => $dword['dword_id'],
                                    'how_related'       => $dword['how_related'],
                                    'created_at'        => Carbon::now(),
                                    'updated_at'        => Carbon::now()
                                ]);
                            }
                        }
                    }
                }

                $actionData['derived'] = $this->extractDerivedWords($word[0]->id);



                if( isset($request->synonyms) ){
                    foreach ($request->synonyms as $row){
                        if(isset($row['syno_id']) && isset($row['syno_word'])){
                            Synonyms::firstOrCreate([
                                'word_id'           => $word[0]->id,
                                'synonym_word_id'   => $row['syno_id']
                            ], [
                                'take'              => 1, //creating manually
                                'created_at'        => Carbon::now(),
                                'updated_at'        => Carbon::now()
                            ]);

//                            $obj = Synonyms::where('word_id', $word[0]->id)
//                                ->where('synonym_word_id', $row['syno_id'])
//                                ->get(['id']);
//                            if(count($obj) == 0){
//                                //create
//                                Synonyms::create([
//                                'word_id'           => $word[0]->id,
//                                'synonym_word_id'   => $row['syno_id'],
//                                'take'              => 1, //creating manually means I want it, so take=1
//                                'created_at'        => Carbon::now(),
//                                'updated_at'        => Carbon::now()
//                                ]);
//                            }else{
//                                //update
//                                Synonyms::where('word_id', $word[0]->id)
//                                    ->where('synonym_word_id', $row['syno_id'])
//                                    ->update(['take'=>$row['take'], 'updated_at'=>Carbon::now() ]);
//                            }
                        }
                        if(isset($row['syno_id']) && ! isset($row['syno_word'])){
                            //intentionally kept blank, so delete
                            Synonyms::where('word_id', $word[0]->id)
                                ->where('synonym_word_id', $row['syno_id'])
                                ->delete();
                        }
                    }
                }

                $actionData['synonyms'] = $this->extractSynonymWords($word[0]->id);




/**************** This chunk will have to be uncommented in future *****************/

//                if( isset($request->antonyms) ){
//                    foreach ($request->antonyms as $row){
//                        if(isset($row['anto_id']) && isset($row['anto_word'])){
//                            Antonyms::firstOrCreate([
//                                'word_id'           => $word[0]->id,
//                                'antonym_word_id'   => $row['anto_id']
//                            ], [
//                                'created_at'        => Carbon::now(),
//                                'updated_at'        => Carbon::now()
//                            ]);
//                        }
//                        if(isset($row['anto_id']) && ! isset($row['anto_word'])){
//                            //intentionally kept blank, delete
//                            Antonyms::where('word_id', $word[0]->id)
//                                ->where('antonym_word_id', $row['anto_id'])
//                                ->delete();
//                        }
//                    }
//                }
//
//                $actionData['antonyms'] = $this->extractAntonymWords($word[0]->id);
            }






            if($request->usage){
                foreach ($request->usage as $row){
                    if( isset($row['usage_id']) && isset($row['sentence'])){
                        //usage exist, update it
                        WordUsages::where('id', $row['usage_id'])
                            ->update(['sentence' => $row['sentence']]);
                    }
                    if( ! isset($row['usage_id']) && isset($row['sentence'])){
                        //new usage , insert it
                        WordUsages::create([
                            'word_id'           => $word[0]->id,
                            'sentence'          => $row['sentence'],
                            'created_at'        => Carbon::now(),
                            'updated_at'        => Carbon::now()
                        ]);
                    }
                    if( isset($row['usage_id']) && ! isset($row['sentence']) ){
                        //user intends to keep it blank, i.e. delete it
                        WordUsages::where('id', $row['usage_id'])->delete();
                    }
                }
            }
            $usage = WordUsages::where('word_id', $word[0]->id)->get(['id', 'sentence']);
            $actionData['usage'] = $usage;

//            $this->setPageUpdateFirebase([
//                'admin/updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
//                'admin/last_saved_word' => $word[0]->word
//            ]);


            return $actionData;
        }
        else{
            //word doesn't exist. insert it along with all data pertaining it
            $insertedWord = Words::create([
                'word'              => $baseWord,
                'is_base_word'      => $request->base_or_derived[0],
                'is_derived_word'   => $request->base_or_derived[1]
            ]);

            if($request->bangla_meaning){
                $rows = [];
                foreach ($request->bangla_meaning as $meaning){
                    array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=>$meaning['bangla_meaning'], 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                }
                Meanings::insert($rows);
            }

            $rows = [];
            foreach ($request->parts_of_speech as $pof){
                array_push($rows, ['word_id'=>$insertedWord->id, 'parts_of_speech'=>$pof['pof_val'], 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
            }
            PartsOfSpeech::insert($rows);

            Mnemonics::insert([
                'word_id'       => $insertedWord->id,
                'mnemonic'      => $request->mnemonic,
                'updated_at'    => Carbon::now(),
                'created_at'    => Carbon::now()
            ]);

            if($request->word_note || $request->mnemonic_note || $request->derivation_note || $request->usage_note){
                Notes::create([
                    'word_id'       => $insertedWord->id,
                    'word_note'     => $request->word_note,
                    'mnemonic_note' => $request->mnemonic_note,
                    'derivation_note'=> $request->derivation_note,
                    'usage_note'    => $request->usage_note,
                    'created_at'    =>Carbon::now(),
                    'updated_at'    =>Carbon::now()
                ]);
            }



            echo "inserted";
        }



        //return $words;
    }//saveWord()






    function takeOrDiscardSynonym(Request $request){
        $s = Synonyms::where('word_id', $request->wid)
            ->where('synonym_word_id', $request->synoId)
            ->update(['take'=>$request->checkedStatus ]);
        return 'ok';
    }



    function fetchMeanings(Request $request){
        $w = Words::where('word', $request->word)->get(['id']);
        if(count($w)>0){
            $m = Meanings::where('word_id', $w[0]->id)->whereNotIn('bangla_meaning', ['*', '#'])->limit(4)->get(['bangla_meaning']);
            return $m;
        }
    }


    public function fetchWordDetails(Request $request){

        if(! in_array(Auth::id(), MyConstants::$adminIds)){
            abort(403);
        }

        //return $request->all();
        if($request->clickedBtn == "nextBtn" || $request->clickedBtn == "prevBtn"){
            //request came with 'wordId', not with 'word'
            $requestedWordId = ($request->clickedBtn == "nextBtn") ? $request->nextId : $request->prevId;
            $word = Words::where('id', $requestedWordId)->get();
            //return "nav btn";
        }else{
            $word = Words::where('word', $request->requested_word)->get();
            //return "direct input";
        }
        
        if( isset($request->id) ){
            //override previous query
            $word = Words::where('id', $request->id)->get();
            //return $word;
        }

        if( isset($request->minimalView) ){
            $this->minimalView = true;
        }

        //return $word;
        $wordDetails = [];
        if(count($word) > 0){




            $wordDetails['word'] = $word[0];

            $limit = $this->minimalView ? 6 : 100;
            $meanings = Meanings::where('word_id', $word[0]->id)
                ->limit($limit)
                ->get(['id', 'bangla_meaning']);
            if(count($meanings)>0){
                $wordDetails['meanings'] = $meanings;
            }

            $partsOfSpeech = PartsOfSpeech::where('word_id', $word[0]->id)->get(['id', 'parts_of_speech']);
            if(count($partsOfSpeech)>0){
                $wordDetails['parts_of_speech'] = $partsOfSpeech;
            }
            

            $wordDetails['checked_categories'] = $this->checkedCategories($word[0]->id);


            $mnemonic = Mnemonics::where('word_id', $word[0]->id)->get(['mnemonic']);
            if(count($mnemonic)>0){
                $wordDetails['mnemonic'] = $mnemonic;
            }

            
            if(! $this->minimalView){
                //$wordDetails['derived'] = $this->extractDerivedWords($word[0]->id);

                $wordDetails['synonyms'] = $this->extractSynonymWords($word[0]->id);

                //$wordDetails['antonyms'] = $this->extractAntonymWords($word[0]->id);
            }


            if(! $this->minimalView){
                $notes = Notes::where('word_id', $word[0]->id)->get();
                if(count($notes)>0){
                    $wordDetails['notes'] = $notes;
                }
            }

            $limit = $this->minimalView ? 15 : 100;
            $uses = WordUsages::where('word_id', $word[0]->id)
                ->limit($limit)
                ->get(['id','sentence']);
            if(count($uses)>0){
                $wordDetails['uses'] = $uses;
            }

            $confusing = DontConfuseWith::where('word_id', $word[0]->id)->get();
            if(count($confusing)>0){
                $wordDetails['confusing'] = $confusing;
            }



            /* order by id */
            // $next = Words::where('id', '>', $word[0]->id)->limit(1)->get('id');
            // if(count($next) > 0){
            //     $wordDetails['nextId'] = $next[0]->id;
            // }

            // $prev = Words::where('id', '<', $word[0]->id)->orderBy('id', 'desc')->limit(1)->get('id');
            // if(count($prev) > 0){
            //     $wordDetails['prevId'] = $prev[0]->id;
            // }
            /* order by id */


            // but order by id has been abandoned as per my requirements. so now order by display_index
            /* order by display_index */
            if( isset($word[0]->display_index) ){
                $next = Words::where('display_index', '>', $word[0]->display_index)
                    //->whereNotIn('word', $this->wordsmartWords())
                    ->where('importance_level', '>=', MyConstants::$minImportanceLevelForMainWords)
                    //->whereIn('word', $this->someWords())
                    ->orderBy('display_index', 'asc')
                    ->limit(1)->get('id');
                if(count($next) > 0){
                    $wordDetails['nextId'] = $next[0]->id;
                }

                $prev = Words::where('display_index', '<', $word[0]->display_index)
                    //->whereNotIn('word', $this->wordsmartWords())
                    ->where('importance_level', '>=', MyConstants::$minImportanceLevelForMainWords)
                    //->whereIn('word', $this->someWords())
                    ->orderBy('display_index', 'desc')
                    ->limit(1)->get('id');
                if(count($prev) > 0){
                    $wordDetails['prevId'] = $prev[0]->id;
                }
            }
            /* order by display_index */



//            if($request->clickedBtn == "nextBtn"){
//                $this->setPageUpdateFirebase([
//                    'admin/active_word'      => $word[0]->word
//                ]);
//            }


            $wordDetails['clicked'] = $request->clickedBtn;

            //Storage::disk('public')->put('tmp/'.$word[0]->word.'.json', json_encode($wordDetails));

            return $wordDetails;
        }
        else{
            return $wordDetails['word'] = $request->requested_word;
        }
    }//fetchWordDetails()


    public function searchDerivedWord(Request $request){
        //if parts of speech is not set, no result will be found
        $word = DB::table('words as w')->select('w.id', 'w.word', 'p.parts_of_speech')
            ->join('parts_of_speech as p', 'w.id', 'p.word_id')
            ->where('w.word', '=', $request->dword)
            ->get();

        //$word = Words::where('word', $request->dword)->get(['id', 'word']);

        if(count($word) > 0){
            return $word;
        }
        return null;
    }//searchDerivedWord()


    public function searchSynonymWord(Request $request){
        $word = Words::where('word', $request->syno_word)->get(['id', 'word']);
        if(count($word) == 1){
            return $word;
        }
        return null;
    }//searchSynonymWord()


    public function searchAntonymWord(Request $request){
        $word = Words::where('word', $request->anto_word)->get(['id', 'word']);
        if(count($word) == 1){
            return $word;
        }
        return null;
    }


    public function extractDerivedWords($baseWordId){
        $derived = DB::table('words as w')
            ->select('w.id','w.word as dword', 'd.derived_word_id as dword_id', 'd.how_related')
            ->join('derived_words as d','w.id', 'd.derived_word_id')
            ->where('d.word_id', '=', $baseWordId)
            ->get();
        if(count($derived)>0){
            return $derived;
        }
        return null;
    }



    public function extractSynonymWords($baseWordId){
        $syno = DB::table('words as w')
            ->select('w.id','w.word as synoword', 'w.importance_level', 's.synonym_word_id as syno_id', 's.take')
            ->join('synonyms as s','w.id', 's.synonym_word_id')
            ->where('s.word_id', '=', $baseWordId)
            ->orderBy('importance_level', 'desc')
            ->get();
        if(count($syno)>0){
            $syno = $syno->unique();
            return $syno;
        }
        return null;
    }


    public function extractAntonymWords($baseWordId){
        $anto = DB::table('words as w')
            ->select('w.id','w.word as antoword', 'a.antonym_word_id as anto_id')
            ->join('antonyms as a','w.id', 'a.antonym_word_id')
            ->where('a.word_id', '=', $baseWordId)
            ->get();
        if(count($anto)>0){
            return $anto;
        }
        return null;
    }
    
    public function checkedCategories($wordId){
        $wordCats = WordCategories::where('word_id', $wordId)->get();
        if(count($wordCats)>0){
            $categories = [];
            foreach ($wordCats as $wordCat){
                array_push($categories, $wordCat->category_id);
            }
            return $categories;
        }
        return null;
    }



    public function showDisplayIndex(Request $request){
        return view('admin.display_index');
    }

    public function diIndexSearchWord(Request $request){
        $word = Words::where('word', $request->word)->get(['id', 'word', 'display_index']);
        if(count($word)>0){
            $nextWord = Words::where('word', '>', $word[0]->word)->limit(1)->get();
            return [
                'thisWord'  => $word,
                'nextWord'  => $nextWord
            ];
        }
        return null;
    }

    public function diIndexReassign(Request $request){
        $ref = Words::where('word', $request->refWord)->get();
        //return $ref;
        if(count($ref) > 0){
            $immediateHigherIndex = Words::where('display_index', '<' ,$ref[0]['display_index'])
                ->orderBy('display_index', 'desc')->limit(1)->get();
            if(count($immediateHigherIndex) > 0){
                //any display_index MUST be integer figure, the whole system along with mobile app is built assuming this
                $newIndex = round( ($immediateHigherIndex[0]['display_index'] + $ref[0]['display_index'])/2 );
                //return $newIndex;
                Words::where('word', $request->niWord)->update(['display_index' => $newIndex]);
                return 'ok';
            }
        }
    }


    public function saveWordCategory(Request $request){
        //return $request->all();
        $word = Words::where('word', $request->word)->get(['id']);
        if(count($word)>0){
            $categoryId = $request->category;
            $action = $request->action;
            if($action == 'tick'){
                //insert it, if not exist
                WordCategories::firstOrCreate([
                    'word_id'       => $word[0]->id,
                    'category_id'   => $categoryId
                ], [
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ]);
            }elseif ($action == 'untick'){
                //delete it
                WordCategories::where('word_id', $word[0]->id)
                    ->where('category_id', $categoryId)
                    ->delete();
            }
        }
    }


    function wordsmartWords(){
        $path = storage_path()."/res/wordsmart12_words_meanings.json";
        $wordSmartWordBanglaMeanings = json_decode(file_get_contents($path));

        $wordsmartWordArr = [];
        foreach ($wordSmartWordBanglaMeanings as $obj){
            array_push($wordsmartWordArr, $obj->word);
        }
        return $wordsmartWordArr;
    }



    function loadUnusedWords(Request $request){
        $showingWord = $request->showingWord;

        $path = storage_path()."/res/wordsmart12_words_meanings.json";
        $wordSmartWordBanglaMeanings = json_decode(file_get_contents($path));

        $wordsmartWordArr = [];
        foreach ($wordSmartWordBanglaMeanings as $obj){
            array_push($wordsmartWordArr, $obj->word);
        }

        $queried = Words::where('id', '<=', '3900')->where('word', '<', $showingWord)
            ->whereIn('word', $wordsmartWordArr)
            ->get();

        $onlyWords = [];
        foreach ($queried as $obj){
            array_push($onlyWords, $obj->word);
        }
        return $onlyWords;
    }


    function fetchWOrdByBanglaMeaning(Request $request){
        //return $request->all();
        $meanings = Meanings::where('bangla_meaning', 'like', '%'.$request->banglaText.'%')->get();
        //return $meanings;
        $retVal = [];
        foreach ($meanings as $meaningObj){
            $wordObj = Words::where('id', $meaningObj->word_id)->get();
            if(count($wordObj) > 0){
                $myObj['word'] = $wordObj[0]->word;
                $myObj['id'] = $wordObj[0]->id;
                $myObj['meaning'] = $meaningObj->bangla_meaning;
                array_push($retVal, $myObj);
            }
        }
        return $retVal;
    }





    function setPageUpdateFirebase($data){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/home-automation-1-52a8d-firebase-adminsdk-woiwh-f71504bcb5.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://home-automation-1-52a8d.firebaseio.com')
            ->create();

        $database = $firebase->getDatabase();

        $page = $database
            ->getReference('wordmaster/page_update/')
            ->update($data);
        //print_r($page->getValue());
    }



    function showSearchSentence(Request $request){
        return view('admin/search_sentence');
    }

    function doSearchSentence(Request $request){
        $word = $request->word;
        $result = DB::connection('misc')
            ->select("select * from news where news_details like '%$word%' or headline like '%$word%' limit 100");
        return $result;
    }



    function someWords(){
        return ["ABNEGATE", "ACCOST", "ACERBIC", "ADDRESS", "AGENDA", "ALLOCATE", "AMORAL", "ANGUISH", "APOCALYPSE", "APPRECIATE", "ARBITRARY", "ARISTOCRATIC", "ATHEIST", "AUTOCRATIC", "AUTONOMOUS", "AVUNCULAR", "AXIOM", "BEGET", "BELABOR", "BELIE", "BELITTLE", "BEMUSED", "BEREAVED", "BLASPHEMY", "CAPITALISM", "CARICATURE", "CHARISMA", "CONCISE", "CONCURRENT", "CONVENTIONAL", "CRITERION", "CULINARY", "DAUNT", "DEBAUCHERY", "DEFAME", "DEMAGOGUE", "DEXTROUS", "DISCRIMINATE", "DISSIPATE", "DISSOLUTION", "DISTINGUISH", "DOCTRINAIRE", "DOGMATIC", "DOMESTIC", "ECLECTIC", "EFFUSION", "EGOCENTRIC", "ELLIPTICAL", "ENDEMIC", "ENFRANCHISE", "EXISTENTIAL", "EXPLICIT", "EXTROVERT", "FIGURATIVE", "FINESSE", "FLAUNT", "FORBEAR", "FOREGO", "FRENETIC", "GENRE", "GRAVITY", "HOMOGENEOUS", "HUSBANDRY", "HYPOTHETICAL", "IDEOLOGY", "IMMUTABLE", "IMPARTIAL", "IMPOTENT", "INAUGURATE", "INCANDESCENT", "INCONGRUOUS", "INCREMENT", "INDIGENOUS", "INERT", "INFINITESIMAL", "INHERENT", "INSIDIOUS", "INTEGRATE", "INTRANSIGENT", "KINETIC", "LATENT", "LUGUBRIOUS", "LUMINOUS", "MANIFEST", "MANIFESTO", "MENDACIOUS", "MENDICANT", "METAMORPHOSIS", "MITIGATE", "MORIBUND", "MYOPIA", "NEFARIOUS", "NOMINAL", "NOTORIOUS", "OBFUSCATE", "OPAQUE", "PACIFY", "PARADOX", "PARSIMONIOUS", "PATRONIZE", "PEDESTRIAN", "PERIPHERY", "PIOUS", "POLARIZE", "POSTULATE", "PRECEDENT", "PRECIPITOUS", "PREEMPT", "PROLETARIAT", "QUIXOTIC", "REDUNDANT", "RENAISSANCE", "REQUISITE", "ROBUST", "SCINTILLATE", "SECULAR", "SENSORY", "SOBRIETY", "STATIC", "SYNTHESIS", "TRANSIENT", "UNIFORM", "ABOMINATION", "ACCESS", "AD-LIB", "ALLOT", "APPALLING", "ARCHIVES", "ASSESS", "ATROPHY", "ATTEST", "ATTRIBUTE", "AUGUR", "AUSPICES", "AUXILIARY", "BEHEST", "BON VIVANT", "CACHE", "CANON", "CANT", "CANVASS", "CAPITAL", "CHANNEL", "CHORTLE", "CLASSIC", "CLONE", "COMPATIBLE", "CONCAVE", "CORRELATION", "DEGRADE", "DEITY", "DEJECTED", "DEPLOY", "DISAFFECT", "DIVINE", "DOLDRUMS", "DOUBLE ENTENDRE", "ECCLESIASTICAL", "ELITE", "EMPOWER", "ENTREPRENEUR", "ETHICS", "FORSWEAR", "FUEL", "GALVANIZE", "GENERIC", "IDIOM", "IMPOVERISH", "INCARNATION", "INFLAMMATORY", "INFRASTRUCTURE", "IRIDESCENT", "JUNCTION", "KARMA", "LASCIVIOUS", "LYRICAL", "MEDIUM", "MODE", "MOMENTUM", "MYSTIC", "NIRVANA", "NOMENCLATURE", "NULLIFY", "ORDINANCE", "OSCILLATE", "OVERRIDE", "OVERTURE", "PARALLEL", "PARTITION", "PILGRIMAGE", "PRESUPPOSE", "PROTOCOL", "PROVOCATION", "PUNDIT", "QUERY", "RESIGNATION", "SALUTATION", "SANCTION", "SARCASM", "STIPEND", "STUPENDOUS", "THESIS", "THRESHOLD", "TOIL", "TOXIC", "UNILATERAL", "WAKE"];
    }



    public function nextDisplayableWord($givenWord){
        $nextWord = Words::where('display_index', '>', function ($query) use ($givenWord){
            $query->select('display_index')
                ->from('words')
                ->where('word', $givenWord);})
            ->where('importance_level', '>', MyConstants::$minImportanceLevelForMainWords)
            ->orderBy('display_index', 'asc')
            ->pluck('word')
            ->first();
        return $nextWord; //null if no value
    }



    private $highFrequency328 = ["admonish","aesthetic","abeyance","abstinent","alacrity","amalgamate","anarchy","anomaly","antipathy","abate","aberration","absconder","adulterate","aggregate","alleviate","ambiguous","ambivalent","ameliorate","anachronism","analogy","apathy","appease","apprise","approbation","appropriate","arduous","artless","ascetic","assiduous","assuage","attenuate","audacity","austere","aver","banal","belie","benefactor","bolster","bombast","boorish","burgeon","burlesque","buttress","cacophony","capricious","castigate","catalyst","caustic","chicanery","coagulate","cognitive","cogent","commensurate","compendium","complaisant","compliant","conciliatory","condone","confound","connoisseur","contention","contentious","contrite","conundrum","converge","convene","craven","daunt","dearth","debacle","deference","delineate","denigrate","deride","derogatory","desiccate","desultory","deterrent","diatribe","dichotomy","diffident","diffuse","digress","dirge","dilate","dilemma","discord","discourteous","discrepancy","discrete","disdain","disinterested","dismay","dismiss","disparage","disparate","dissemble","disseminate","dissolution","dissuade","distend","distinct","divergence","divest","document","dogmatic","dormant","dupe","ebullient","eclectic","efficacy","effrontery","elegy","elicit","embellish","empirical","emulate","endemic","enervate","engender","epicure","ephemeral","equanimity","equivocal","erudite","esoteric","eulogy","euphemism","exacerbate","exculpate","exigency","extrapolate","facetious","facilitate","fallacy","fatuous","fawning","fiasco","fervor","flamboyant","fledgling","flout","foment","forestall","frugal","futile","gainsay","garrulous","fuel","fulminate","grandiloquent","gregarious","guile","gullible","hackneyed","homogeneous","hyperbole","iconoclast","idiosyncrasy","immutable","impair","impassive","impede","impermeable","imperturbable","impervious","implacable","imposter","impregnable","inadvertent","insouciant","incongruous","inconsequential","instigate","indeterminate","indigent","indolent","inert","ingenuous","inherent","innocuous","insensible","insinuate","insipid","insular","intractable","intransigent","inundate","inure","invective","irascible","irresolute","itinerant","laconic","lassitude","latent","laud","lethargic","libel","levity","listless","loquacious","lucid","luminous","magnanimous","malinger","malleable","maverick","mendacity","metamorphosis","meticulous","misogyny","misanthrope","mitigate","mollify","morose","mundane","negate","neophyte","obdurate","obsequious","obviate","occult","officious","onerous","oscillate","ostentatious","paragon","partisan","pathological","paucity","pedantic","penchant","penurious","perennial","perfidy","perfunctory","peril","pervasive","phlegmatic","piety","placate","plasticity","platitude","plethora","plummet","porous","pragmatic","preamble","precarious","precipitate","precursor","presumptuous","prevaricate","pristine","probity","proclaim","prodigal","profound","prohibit","proliferate","propensity","propitiate","propriety","proscribe","pungent","qualified","quibble","quiescent","rarefied","recalcitrant","recant","recluse","recondite","refractory","refute","relegate","reproach","reprobate","repudiate","rescind","resolve","reticent","revere","sage","salubrious","sanction","satiate","saturate","savor","secrete","skeptical","soporific","specious","spectrum","sporadic","stigmatize","stint","stipulate","stolid","strut","subside","substantiate","supersede","supposition","tacit","tangential","tenuous","tirade","torpor","tortuous","tractable","transgress","truculence","vacillate","venerate","veracious","verbose","viable","viscous","vituperative","volatile","wary","whimsical","zealot"];


    public function exportWordsPdf(Request $request){
        ini_set("max_execution_time", 30000);

        $time = date('Y-m-d__h-i-s');
        $savePath = storage_path().'\app\public\exportedPdf\words-'.$time.'.pdf';

        $allWordsData = [];
        foreach ($this->highFrequency328 as $index => $w){
            $data = [];
            $i=0;
            $row = Words::where('word', $w)->select('id')->get();
            if(count($row)>0){
                $wordId = $row[0]->id;
                $request['id'] = $wordId;
                $word = $this->fetchWordDetails($request);
                $data['word'] = $w;
                $meanings = @$word['meanings'];
                if($meanings){
                    if(count($meanings) > 0){
                        $data['meanings'] = [];
                        $data['definitions'] = [];
                        foreach ($meanings as $meaning){
                            $m = trim( @$meaning['bangla_meaning'] );
                            if(!is_null($m) && $m != ""){
                                if(str_starts_with($m, "*")){
                                    $m = substr($m, 1);
                                }
                                if(str_starts_with($m, "#")){
                                    $m = substr($m, 1);
                                }
                                $m = str_replace("\n", "<br>", $m);
                                if($index <= 5){
                                    $m = str_replace("[ox]", "[Oxford Dictionary]", $m);
                                    $m = str_replace("[cam]", "[Cambridge Dictionary]", $m);
                                }else{
                                    $m = str_replace("[ox]", "[Oxford]", $m);
                                    $m = str_replace("[cam]", "[Cambridge]", $m);
                                }

                                if($i <= 1){
                                    array_push($data['meanings'], $m);
                                }else if($i >=2 && $i<=3){
                                    if(str_starts_with($m, "<span")){ /* #(hash sign) already trailed */
                                        array_push($data['definitions'], $m);
                                    }
                                }
                            }
                            if(++$i >= 4) break;
                        }

                        $pof = @$word['parts_of_speech'][0]['parts_of_speech'];
                        if($pof){
                            $data['pof'] = $pof;
                        }

                        $mnemonic = @$word['mnemonic'];
                        if(!is_null($mnemonic)){
                            $mn = @$word['mnemonic'][0]['mnemonic'];
                            // remove font size assigned by nicEdit
                            $mn = str_replace("font-size:", "", $mn); //it works !
                            $data['mnemonic'] = $mn;
                        }

                        $note = @$word['notes'][0]['word_note'];
                        if($note){
                            $data['note'] = $note;
                        }

                        $sentences = @$word['uses'];
                        if($sentences){
                            if(count($sentences) > 0){
                                $i = 0;
                                $data['sentence'] = [];
                                foreach ($sentences as $sentence){
                                    if( !str_starts_with($sentence, ">") && strlen($sentence->sentence) > 10){
                                        array_push($data['sentence'], $sentence->sentence);
                                        if(++$i >= 2) break;
                                    }
                                }
                            }
                        }

                        $synonyms = $word['synonyms'];
                        if(isset($synonyms) && count($synonyms) > 0){
                            $synoList = [];
                            foreach ($synonyms as $synonym){
                                if($synonym->importance_level >= 80){
                                    array_push($synoList, $synonym->synoword);
                                }
                            }
                            $data['synonyms'] = $synoList;
                        }
                    } //no meaning
                    else{
                        //as meaning doesn't exist. don't take this
                        //return $w.' no meanings';
                    }
                }
            }

            array_push($allWordsData, $data);

            //if($index >= 14) break;
        }

        //return $allWordsData;
        $data = $allWordsData;
        $appLink = "https://jovoc.com?p=highF330";

        return view('pdf_generator.export_words', compact('data', 'appLink'));

        $html = view('pdf_generator.export_words', compact('data'))->render();
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');


        $pdf = Pdf::loadView('pdf_generator.export_words', compact('data'))->save($savePath);
    }





}
