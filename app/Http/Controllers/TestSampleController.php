<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Contents\FacebookPagePostingHelper;
use App\Http\Controllers\Processor\ImageProcessor;
use App\Models\Antonyms;
use App\Models\DerivedWords;
use App\Models\Meanings;
use App\Models\Mnemonics;
use App\Models\PartsOfSpeech;
use App\Models\PreviousJobExams;
use App\Models\Synonyms;
use App\Models\WordCategories;
use App\Models\Words;
use App\Models\WordUsages;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

//use League\Flysystem\Filesystem;
//use phpseclib3\Net\SSH2;
//use SimpleXMLElement;
//use Spatie\Dropbox\Client;
//use Spatie\FlysystemDropbox\DropboxAdapter;

use App\Http\Controllers\Contents\SocialMediaPostContents;
use function Symfony\Component\Finder\size;


class TestSampleController extends Controller
{

    private $TEST_RUN = false;
    private $TEST_WORDS_NUM = 3;
    /* In production, all words must be inserted at single run, because display_index is calculated by $i*1000. At every run $i starts from 0, so display_index will repeat (!! DANGER !!) */




    public function test(){
        ini_set("max_execution_time", 30000);


        $someWords = ["abnegate","ACCOST", "ACERBIC", "ADDRESS", "AGENDA", "ALLOCATE", "AMORAL", "ANGUISH", "APOCALYPSE", "APPRECIATE", "ARBITRARY", "ARISTOCRATIC", "ATHEIST", "AUTOCRATIC", "AUTONOMOUS", "AVUNCULAR", "AXIOM", "BEGET", "BELABOR", "BELIE", "BELITTLE", "BEMUSED", "BEREAVED", "BLASPHEMY", "CAPITALISM", "CARICATURE", "CHARISMA", "CONCISE", "CONCURRENT", "CONVENTIONAL", "CRITERION", "CULINARY", "DAUNT", "DEBAUCHERY", "DEFAME", "DEMAGOGUE", "DEXTROUS", "DISCRIMINATE", "DISSIPATE", "DISSOLUTION", "DISTINGUISH", "DOCTRINAIRE", "DOGMATIC", "DOMESTIC", "ECLECTIC", "EFFUSION", "EGOCENTRIC", "ELLIPTICAL", "ENDEMIC", "ENFRANCHISE", "EXISTENTIAL", "EXPLICIT", "EXTROVERT", "FIGURATIVE", "FINESSE", "FLAUNT", "FORBEAR", "FOREGO", "FRENETIC", "GENRE", "GRAVITY", "HOMOGENEOUS", "HUSBANDRY", "HYPOTHETICAL", "IDEOLOGY", "IMMUTABLE", "IMPARTIAL", "IMPOTENT", "INAUGURATE", "INCANDESCENT", "INCONGRUOUS", "INCREMENT", "INDIGENOUS", "INERT", "INFINITESIMAL", "INHERENT", "INSIDIOUS", "INTEGRATE", "INTRANSIGENT", "KINETIC", "LATENT", "LUGUBRIOUS", "LUMINOUS", "MANIFEST", "MANIFESTO", "MENDACIOUS", "MENDICANT", "METAMORPHOSIS", "MITIGATE", "MORIBUND", "MYOPIA", "NEFARIOUS", "NOMINAL", "NOTORIOUS", "OBFUSCATE", "OPAQUE", "PACIFY", "PARADOX", "PARSIMONIOUS", "PATRONIZE", "PEDESTRIAN", "PERIPHERY", "PIOUS", "POLARIZE", "POSTULATE", "PRECEDENT", "PRECIPITOUS", "PREEMPT", "PROLETARIAT", "QUIXOTIC", "REDUNDANT", "RENAISSANCE", "REQUISITE", "ROBUST", "SCINTILLATE", "SECULAR", "SENSORY", "SOBRIETY", "STATIC", "SYNTHESIS", "TRANSIENT", "UNIFORM", "ABOMINATION", "ACCESS", "AD-LIB", "ALLOT", "APPALLING", "ARCHIVES", "ASSESS", "ATROPHY", "ATTEST", "ATTRIBUTE", "AUGUR", "AUSPICES", "AUXILIARY", "BEHEST", "BON VIVANT", "CACHE", "CANON", "CANT", "CANVASS", "CAPITAL", "CHANNEL", "CHORTLE", "CLASSIC", "CLONE", "COMPATIBLE", "CONCAVE", "CORRELATION", "DEGRADE", "DEITY", "DEJECTED", "DEPLOY", "DISAFFECT", "DIVINE", "DOLDRUMS", "DOUBLE ENTENDRE", "ECCLESIASTICAL", "ELITE", "EMPOWER", "ENTREPRENEUR", "ETHICS", "FORSWEAR", "FUEL", "GALVANIZE", "GENERIC", "IDIOM", "IMPOVERISH", "INCARNATION", "INFLAMMATORY", "INFRASTRUCTURE", "IRIDESCENT", "JUNCTION", "KARMA", "LASCIVIOUS", "LYRICAL", "MEDIUM", "MODE", "MOMENTUM", "MYSTIC", "NIRVANA", "NOMENCLATURE", "NULLIFY", "ORDINANCE", "OSCILLATE", "OVERRIDE", "OVERTURE", "PARALLEL", "PARTITION", "PILGRIMAGE", "PRESUPPOSE", "PROTOCOL", "PROVOCATION", "PUNDIT", "QUERY", "RESIGNATION", "SALUTATION", "SANCTION", "SARCASM", "STIPEND", "STUPENDOUS", "THESIS", "THRESHOLD", "TOIL", "TOXIC", "UNILATERAL", "WAKE"];

        //return $someWords;

        
        $wf5 = ["Indifferent", "Vindictive", "Tiny", "Lethargic", "Transparent"];
        $wf4 = ["Diligent", "Profound", "Ingenious", "Articulate", "Cursory", "Amateur", "Eulogy", "Lucid", "Sophisticated", "Spurious", "Panacea", "Indigent", "Fragile"];
        $wf3 = ["Capable", "Depressed", "Suggest", "Facilitate", "Concur", "Hinder", "Inborn", "Meticulous", "Specious", "Serene", "Memento", "Rebuke", "Lucrative", "Ingenuous", "Inflation", "Opaque", "Gentle", "Die by", "Extol", "Loyalty", "Profitable", "Transient", "Industrious", "Reprimand", "Philanthropist", "Complacency", "Pardon", "Loquacious", "Retreat", "Postulate", "Coward", "Alleviate", "Appreciate", "Possess", "Aggravate", "Vigilant", "Proliferate", "Lax", "Lizard", "Obstinate", "Put up with", "Obscure", "Ambiguous", "Superficial", "Indolent", "Enlarge", "Inadvertent", "Vacillate", "Thrive", "Generosity", "Protract", "Deference", "Anomalous", "Entrepreneur", "Distant", "Innate", "Paucity", "Irregular", "Incorrigible"];

        $words = array_merge($wf5, $wf4, $wf3);
        $data = [];
        $testw = ["hinder", "Vacillate"];
//return view('test.test', compact('data'));


        $w = PreviousJobExams::whereIn('word', $wf3)
            ->get(['word','exam', 'post_name', 'year'])
            ->groupBy('word');
        foreach ($w as $key=>$obj){
            try{
                $objectArray = [];
                foreach ($obj as $item){
                    $object['word'] = $key;
                    $object['exam'] = $item['exam'];
                    $object['post'] = $item['post_name'];
                    $object['year'] = $item['year'];

                    //$key = 'enlarge';
                    $word = Words::where('word', $key)->get();
                    if(count($word)>0){
                        $meanings = Meanings::where('word_id', $word[0]->id)
                            //->whereNotIn('bangla_meaning', ['*', '#'])
                            ->limit(2)
                            ->get(['bangla_meaning']);
                        if(count($meanings)>0){
                            $mean = "";
                            foreach ($meanings as $meaning){
                                $meaning = $meaning->bangla_meaning;
                                $meaning = substr($meaning, 1);
                                if($meaning != '' || !empty($meaning) || isset($meaning)){
                                    $mean = $mean.$meaning.' , ';
                                }
                            }
                            $mean = trim($mean);
                            $mean = substr($mean, 0, -2);
                            $object['meaning'] = $mean;
                            //return $mean;

                            array_push($objectArray, $object);
                        }
                    }
                }
                array_push($data, $objectArray);
                $objectArray = [];
            }catch (\Exception $e){
            }
        }
        //return $data;
        return view('test.test', compact('data'));

        foreach ($data as $object){
            foreach ($object as $item){
                echo $item['word'].' - '.$item['exam'].'<br>';
            }
        }



        //return view('test/test');
    }



    function testAjax(Request $request){
        $img = $request->data;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);

        $fileName = storage_path().'/app/public/canvas/'.$request->frequency.'-'.$request->word.'.png';
        file_put_contents($fileName, $fileData);

        return $fileName;
    }



    function diIndexReassign($refWord, $niWord){
        $ref = Words::where('word', $refWord)->get();
        //return $ref;
        if(count($ref) > 0){
            $immediateHigherIndex = Words::where('display_index', '<' ,$ref[0]['display_index'])
                ->orderBy('display_index', 'desc')->limit(1)->get();
            if(count($immediateHigherIndex) > 0){
                //any display_index MUST be integer figure, the whole system along with mobile app is built assuming this
                $newIndex = round( ($immediateHigherIndex[0]['display_index'] + $ref[0]['display_index'])/2 );
                //return $newIndex;
                Words::where('word', $niWord)->update(['display_index' => $newIndex]);
                return 'ok';
            }
        }
    }


    function autoReassignIndex($w){
        $word = Words::where('word', $w)->get(['id', 'word', 'display_index']);
        $nextWord = Words::where('word', '>', $word[0]->word)->limit(1)->get();
        $niWord = $word[0]->word;
        $refWord = $nextWord[0]->word;
        $status = $this->diIndexReassign($refWord, $niWord);
        echo $niWord.' <= '.$refWord.'  --  '.$status.'<br>';
    }




    function wordsmartButNotListedAsMain(){
        ini_set("max_execution_time", 30000);

        $path = storage_path()."/res/wordsmart12_words_meanings.json";
        $wordSmartWordBanglaMeanings = json_decode(file_get_contents($path));
        //return $wordSmartWordBanglaMeanings;
        $notInMain = [];
        foreach ($wordSmartWordBanglaMeanings as $obj){
            $q = Words::where('word', $obj->word)
                //->where('importance_level', '<', 90)
                ->get();
            if(count($q) == 0){
                array_push($notInMain, $obj->word);
                //Words::where('word', $obj->word)->update(['importance_level'=>90]);
            }
        }
        return $notInMain;
    }


    function insertMoreWords(){
        ini_set("max_execution_time", 30000);
        if (ob_get_level() == 0) ob_start();

        $path = storage_path()."/res/not_in_db_but_inwordsmart.txt";
        $words = fopen($path, "rb");
        $i=0;
        if($words) {
            while (!feof($words)) {
                $line = fgets($words);
                $word = trim(preg_replace('/\s\s+/', '', $line));

                $obj = Words::where('word', $word)->get();
                if( count($obj) ==0 ){
                    //doesn't exist . insert it
                    $insertedWord = Words::create([
                        'word'              => $word,
                        'is_base_word'      => 0,
                        'is_derived_word'   => 0,
                        'display_index'     => null,
                        'importance_level'  => 90
                    ]);
                    echo 'inserted '.$insertedWord->word.'['.$insertedWord->id.']';
                }

                $obj = Words::where('word', $word)
                    ->where('display_index', null)
                    ->get();
                if(count($obj)>0){
                    //if this word display_index is null, then
                    $obj = Words::where('word', '>', $word)
                        ->limit(1)->get();
                    if( count($obj)>0 ){
                        if( strpos($word, '-') == false ){
                            //if word doesn't contain a '-' (dash)
                            $nextW = $obj[0]['word'];
                            $id = $obj[0]['id'];
                            echo "<p> to set index of $word before $nextW [$id]  </p>";

                            $request = new Request();
                            $request['refWord'] = $nextW;
                            $request['niWord'] = $word;

                        $status = (new AdminController())->diIndexReassign($request);
                        if($status=='ok'){
                            echo 'done<hr>';
                        }else{
                            echo 'error <hr>';
                        }

                            ++$i;
                        }
                    }

                    //if($i == 2) break;


                    ob_flush();
                    flush();
                }
            }
            echo "<p>total $i operations done</p>";
        }
        ob_end_flush();
    }


    function dropboxTest(){

        $file = fopen(public_path('images/test_img.png'), 'rb');
        $size = filesize(public_path('images/test_img.png'));
        $dropboxFileName = 'test2.png';

        //Storage::disk('dropbox')->put($dropboxFileName, $file);
        return Storage::disk('dropbox')->allDirectories();

    }

    function dbBackup(){
        $ssh = new SSH2('server10.hostever.com', 1004);

        if (!$ssh->login('jovoccom', '2-xxpWtA1!H6J3')) {
            exit('Login Failed');
        }

        $today = date('Y-m-d');
        $command = "mysqldump -u'jovoccom_partho' -p'cQ+SUobXh8c?' jovoccom_jovoc | gzip -9 > /public_html/jovoc/backup/wordmaster_db_$today.sql.zip";
        //echo $command;
        echo "<pre>".$ssh->exec($command)."</pre>";
        echo "<p style='font-size:3em'>backup saved in webserver</p>";
    }

    function saveToDropbox(){
        $todayDate = date('Y-m-d');
        $fname = 'jovoc_com';
        $sqlFilePath = base_path().'/backup/'.$fname.'_'.$todayDate.'.sql.zip';
        //return $sqlFilePath;

        try{
            $file = fopen($sqlFilePath, 'rb');
            $size = filesize($sqlFilePath);
            //return $size;
            $dropboxSaveName = 'devResource/'.$fname.'_'.$todayDate.'.sql.zip';

            try{
                Storage::disk('dropbox')->delete($dropboxSaveName);//delete if exists, because dropbox API won't overwrite out of the box
            }catch (\Exception $e){
                echo $e->getMessage();
            }

            Storage::disk('dropbox')->writeStream($dropboxSaveName, $file);

            echo "<h3 style='font-size:3em'>saved in dropbox as $dropboxSaveName</h3>";
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function cambridgeWordsBulkInsert(){
        $path = storage_path()."/res/cambridge_crawled_words_meaning_usages.json";
        $cambridgeWords = json_decode(file_get_contents($path, true));
        //return $words;

        $path = storage_path()."/res/epizy_bangla_meanings_mnemonics_projection.json";
        $bnProjection = json_decode(file_get_contents($path, true));
        //return $bnProjection;

        $path = storage_path()."/res/wordsmart12_words_meanings.json";
        $wordSmartWordBanglaMeanings = json_decode(file_get_contents($path));
        //return $wordSmartWordBanglaMeanings;

        $path = storage_path()."/res/english-bangla.com_word_meaning.json";
        $englishBanglaDotComMeanings = json_decode(file_get_contents($path));
        //return $englishBanglaDotComMeanings;

        $path = storage_path()."/res/word_definition_probable_synonyms_from_google.json";
        $googleMeaningsProbableSynonyms = json_decode(file_get_contents($path));
        //return $googleMeaningsProbableSynonyms;

        ini_set("max_execution_time", 30000);

        $i=0;
        foreach($cambridgeWords as $word){
            if(count($word->definition) > 0){
                ++$i;
                //word exists in cambridge dictionary
                $wc = Words::where('word', $word->word)->get('id')->count();
                if($wc == 0){
                    //word NOT exists in db

                    if($this->TEST_RUN){
                        if($i > $this->TEST_WORDS_NUM){
                            return redirect()->to('/test/saw');
                            return "<p>-------done--------</p>";
                        }else{
                            echo "<p>[$i] inserted : $word->word </p>";
                        }
                    }

                    $insertedWord = Words::create([
                        'word'              => $word->word,
                        'is_base_word'      => 1,
                        'is_derived_word'   => 0,
                        'display_index'     => $i*1000
                    ]);



                    $rows = [];
                    foreach ($word->pof as $value){
                        array_push($rows, ['word_id'=>$insertedWord->id, 'parts_of_speech'=>$value, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    }
                    PartsOfSpeech::insert($rows);


                    //insert a blank(containing barely * and #) meaning field, that will help me a lot to write my own meaning
                    $rows = ['word_id'=>$insertedWord->id, 'bangla_meaning'=>"*", 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    Meanings::insert($rows);

                    $rows = ['word_id'=>$insertedWord->id, 'bangla_meaning'=>"#", 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    Meanings::insert($rows);

                    $rows = ['word_id'=>$insertedWord->id, 'bangla_meaning'=>"#", 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    Meanings::insert($rows);

                    $rows = ['word_id'=>$insertedWord->id, 'bangla_meaning'=>"#", 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
                    Meanings::insert($rows);

                    //insert ****my created****  bangla meanings
                    foreach ($bnProjection as $bnRow){
                        if($word->word == $bnRow->word){
                            //bangla meaning exists for this word. Insert bn meaning first
                            $rows = [];
                            foreach ($bnRow->meaning as $bnMeaning){
                                array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=>$bnMeaning, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                            }
                            Meanings::insert($rows);
                        }
                    }

                    //insert english-bangla.com bangla meaning
                    foreach ($englishBanglaDotComMeanings as $bnRow){
                        if($word->word == strtolower($bnRow->word)){
                            //english-bangla.com bangla meaning also exists for this word. Insert that
                            if($this->TEST_RUN){
                                echo "<small style='color:gray'>(english-bangla.com meaning available for $word->word)</small><br>";
                            }
                            $rows = [];
                            array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=>$bnRow->meaning, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                            Meanings::insert($rows);

                            break;
                        }
                    }


                    //insert  *****word smart*******  bangla meanings
                    foreach ($wordSmartWordBanglaMeanings as $bnRow){
                        if($word->word == strtolower($bnRow->word)){
                            //word smart bangla meaning also exists for this word. Insert that
                            if($this->TEST_RUN){
                                echo "<small style='color:gray'>(word smart meaning available for $word->word)</small><br>";
                            }
                            $rows = [];
                            array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=>$bnRow->meaning, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                            Meanings::insert($rows);

                            break;
                        }
                    }



                    //insert ******cambridge*******  meanings
                    $rows = [];
                    foreach ($word->definition as $value){
                        array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=>"<span class='cambridge' >[cam]</span>"." ".$value, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    }
                    Meanings::insert($rows);



                    /* insert uses / example sentences got from cambridge */
                    $rows = [];
                    foreach ($word->examples as $value){
                        array_push($rows, ['word_id'=>$insertedWord->id, 'sentence'=>$value, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                    }
                    WordUsages::insert($rows);



                    //insert google crawled words
                    foreach ($googleMeaningsProbableSynonyms as $bnRow){
                        if($word->word == strtolower($bnRow->word)){
                            //google definition also exists for this word. Insert that
                            if($this->TEST_RUN){
                                echo "<small style='color:gray'>(google definition available for $word->word)</small><br>";
                            }
                            $rows = [];
                            foreach($bnRow->definitions as $definition){
                                array_push($rows, ['word_id'=>$insertedWord->id, 'bangla_meaning'=> "<span class='oxford' >[ox]</span>"." ".$definition, 'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]);
                            }
                            Meanings::insert($rows);

                            break;
                        }
                    }
                }
            }
        }

        return redirect()->to('/test/saw');
        return "inserted all words";
    }


    function synAntWebster(){
        ini_set("max_execution_time", 30000);

        $path = storage_path()."/res/synonym_antonym_from_webster.json";
        $webstarWords = json_decode(file_get_contents($path, true));
        //return $words;

        $path = storage_path()."/res/word_definition_probable_synonyms_from_google.json";
        $googleMeaningsProbableSynonyms = json_decode(file_get_contents($path));

        $i=0;
        foreach ($webstarWords as $word){
            if($this->TEST_RUN){
                if($i++ > $this->TEST_WORDS_NUM) break;
            }


            $wordExist = Words::where('word', $word->word)->get();
            if(count($wordExist)>0){
                //this word of syn_ant file exists in db
                $existedWordId = $wordExist[0]->id;


                foreach ($googleMeaningsProbableSynonyms as $gRow){
                    if($word->word == strtolower($gRow->word)){
                        //google synonyms also exists for this word. Insert that
                        $synonymIds = [];
                        foreach ($gRow->synonyms as $synonym){
                            $synExist = Words::where('word', $synonym)->get();
                            if(count($synExist) > 0){
                                array_push($synonymIds, $synExist[0]->id);
                            }else{
                                $insertedSynonym = Words::create([
                                    'word'              => $synonym,
                                    'is_base_word'      => 0,
                                    'is_derived_word'   => 0,
                                ]);
                                array_push($synonymIds, $insertedSynonym->id);
                            }
                        }

                        $data = [];
                        foreach ($synonymIds as $synonymId){
                            array_push($data, [
                                'word_id'           => $existedWordId,
                                'synonym_word_id'   => $synonymId,
                                'created_at'        => Carbon::now(),
                                'updated_at'        => Carbon::now(),
                            ]);
                        }
                        Synonyms::insert($data);

                        break;
                    }
                }


                $synonymIds = [];
                foreach ($word->synonyms as $synonym){
                    $synExist = Words::where('word', $synonym)->get();
                    if(count($synExist) > 0){
                        array_push($synonymIds, $synExist[0]->id);
                    }else{
                        $insertedSynonym = Words::create([
                            'word'              => $synonym,
                            'is_base_word'      => 0,
                            'is_derived_word'   => 0
                        ]);
                        array_push($synonymIds, $insertedSynonym->id);
                    }
                }

                $data = [];
                foreach ($synonymIds as $synonymId){
                    array_push($data, [
                        'word_id'           => $existedWordId,
                        'synonym_word_id'   => $synonymId,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);
                }
                Synonyms::insert($data);



                $antonymIds = [];
                foreach ($word->antonyms as $antonym){
                    $antExist = Words::where('word', $antonym)->get();
                    if(count($antExist) > 0){
                        array_push($antonymIds, $antExist[0]->id);
                    }else{
                        $insertedAntonym = Words::create([
                            'word'              => $antonym,
                            'is_base_word'      => 0,
                            'is_derived_word'   => 0
                        ]);
                        array_push($antonymIds, $insertedAntonym->id);
                    }
                }

                $data = [];
                foreach ($antonymIds as $antonymId){
                    array_push($data, [
                        'word_id'           => $existedWordId,
                        'antonym_word_id'   => $antonymId,
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ]);
                }
                Antonyms::insert($data);
            }
        }
        return "syn ant inserted <br> <a href='/test/cam'>/test/cam</a>";
    }


    function extractBanglaContainingText(){
        ini_set("max_execution_time", 30000);
        $words = Words::where('id', '>', 1)->get(['id', 'word']);
        $wordDetails = [];
        foreach ($words as $word){
            $row['word'] = $word->word;

            $meanings = Meanings::where('word_id', '=', $word->id)->get();
            $m = [];
            foreach ($meanings as $meaning){
                if($this->containsBangla($meaning->bangla_meaning)){
                    array_push($m, $meaning->bangla_meaning);
                }
            }
            if(count($m)>0){
                $row['meaning'] = $m;
                array_push($wordDetails, $row);
            }
        }

        //return;

        return $wordDetails;


        //return $this->uniord("ক");
    }

    function pp($obj){
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }

    function uniord($u){
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2*256 + $k1;
    }

    function containsBangla($s){
        $containsBangla = false;
        $splited = mb_str_split($s);
        foreach ($splited as $c){
            if($this->uniord($c) > 2432 && $this->uniord($c) < 2559){
                //its bengali character
                $containsBangla = true;
            }
        }
        return $containsBangla;
    }




    function questionBankAddMeanings(){

        ini_set('max_execution_time', 3000000);

        $path = storage_path().'/app/public/word_data_for_android';
        $Lib = new Library();

        $WordsPath = $path.'/bcs_questions.json';
        $questionWords = json_decode(file_get_contents($WordsPath), true);

        //return $bcsWords;

        foreach ($questionWords as $i => $json){
            $wordList = $json['wordList'];
            foreach ($wordList as $j => $word){
                $bangla = "";
                $meaning = Meanings::where('word_id', function ($query) use ($word){
                    $query->select('id')
                        ->from('words')
                        ->where('word', $word);
                })
                    ->where('bangla_meaning', '!=', '*')
                    ->where('bangla_meaning', '!=', '#')
                    ->limit(1)
                    ->get();

                if(count($meaning) > 0){
                    $bangla = $meaning[0]['bangla_meaning'];
                    $bangla = $Lib->replaceFirstOccurrence($bangla, "*", "");
                    $bangla = $Lib->replaceFirstOccurrence($bangla, "#", "");
                    $bangla = trim($bangla);

                    if (preg_match('/^[0-9]+\.\s*/', $bangla)) {
                        //remove numbering 1. , 2. etc. if exists. because we will add numbering manually. If we dont remove starting number, some definition may look like: "1.1. definition here"
                        $bangla = preg_replace('/^[0-9]+\.\s*/', '', $bangla);
                    }
                }

                $questionWords[$i]['wordList'][$j] = $word.' - '.$bangla;

                //return $bcsWords;
            }
        }

        return $questionWords;


    }

    function insertTestCategories(){
        ini_set("max_execution_time", 30000);
        $start = round(microtime(true)*1000);
        for($i=2311; $i < 4000; $i++){
            WordCategories::insert([
                [
                    'word_id'       => $i,
                    'category_id'   => 30
                ]
            ]);
            if(rand(1,10) > 5){
                WordCategories::insert([
                    [
                        'word_id'       => $i,
                        'category_id'   => 35
                    ]
                ]);
            }
            if(rand(1,10) > 5){
                WordCategories::insert([
                    [
                        'word_id'       => $i,
                        'category_id'   => 40
                    ]
                ]);
            }
            if(rand(1,10) > 7){
                WordCategories::insert([
                    [
                        'word_id'       => $i,
                        'category_id'   => 45
                    ]
                ]);
            }
        }
        $end = round(microtime(true)*1000);
        return ($end-$start)/1000;
    }

    function insertDerivedWords(){
        ini_set("max_execution_time", 30000);
        $start = round(microtime(true)*1000);
        for($i=5; $i < 4000; $i++){
            DerivedWords::insert([
                [
                    'word_id'           => $i,
                    'derived_word_id'   => rand(1,10000)
                ]
            ]);
            if(rand(1,10) > 5){
                DerivedWords::insert([
                    [
                        'word_id'           => $i,
                        'derived_word_id'   => rand(1,10000)
                    ]
                ]);
            }
            if(rand(1,10) > 7){
                DerivedWords::insert([
                    [
                        'word_id'       => $i,
                        'derived_word_id'   => rand(1,10000)
                    ]
                ]);
            }
        }
        $end = round(microtime(true)*1000);
        return ($end-$start)/1000;
    }

    function insertMnemonics(){
        ini_set("max_execution_time", 30000);
        for($i=11; $i<4000; $i++){
            Mnemonics::insert([
                'word_id'       => $i,
                'mnemonic'      => '<div>A<span style="background-color: rgb(255, 255, 0);">bound</span> &gt;&gt; <span style="background-color: rgb(255, 255, 0);">bound</span></div><font color="#cc0033">this is&nbsp; some mnemonics .</font><div><font color="#0000ff">Oh that\'s good</font></div>'
            ]);
        }
    }


    function rearrangeUses(){
        ini_set("max_execution_time", 30000);

//        $uses = WordUsages::where('word_id', '<=', 3844)
//            ->get()
//            ->groupBy('word_id')
//        ;
//
//        Storage::disk('public')->put('uses.txt', json_encode($uses) );
//        return "done";

        $path = storage_path()."/res/uses.txt";
        $uses = json_decode(file_get_contents($path, true));

        if (ob_get_level() == 0) ob_start();

        $count = 0;

        foreach ($uses as $obj){
            $sentenceArr = ['>', '>', '>', '>', '>'];
            $wid = '' ;
            foreach ($obj as $sentence){
                $wid = $sentence->word_id;
                //echo $sentence->word_id.'<br>';
                array_push($sentenceArr, $sentence->sentence);
            }
            //echo $sentence->word_id.'<hr>';

            foreach ($sentenceArr as $sent){
                WordUsages::create([
                    'word_id'       => $wid,
                    'sentence'      => $sent,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }

            echo "<p>$wid inserted</p>";

            ob_flush();
            flush();

            if(++$count > 100000000000){
                break;
                ob_end_flush();
            }
        }
    }


    function merriamCollingsDefinitionExampleInsert(Request $request){
        ini_set("max_execution_time", 30000);
        $path = storage_path()."/res/merriamCollinsDefinitionExample.json";
        $meriamCollings = json_decode(file_get_contents($path));
        //return $meriamCollings;
        dd($meriamCollings[0]);

        if (ob_get_level() == 0) ob_start();

        $i=0;
        foreach ($meriamCollings as $json){
            $word = $json->word;
            $definitions = $json->definition;
            $examples = $json->example;

            $q = Words::where('word', $word)->get();
            if(count($q)>0){
                $wid = $q[0]->id;

                $bm = [];
                foreach ($definitions as $definition){
                    array_push($bm, [
                        'word_id'       => $wid,
                        'bangla_meaning'=> $definition
                    ]);
                }
                Meanings::insert($bm);

                $ex = [];
                foreach ($examples as $example){
                    array_push($ex, [
                        'word_id'       => $wid,
                        'sentence'      => $example
                    ]);
                }
                WordUsages::insert($ex);
            }
            echo "<p> $word </p>";

            flush(); ob_flush();
            //if($i++ > 10) return;
        }
        ob_end_flush();
    }


    // this function needed for export data for android
    function exportPrevWords(){
        ini_set("max_execution_time", 30000);

        $obj  = PreviousJobExams::where('exam', 'BCS')->get()->groupBy('year');
        //return $obj;
        $bcsDataset = [];
        foreach ($obj as $key=>$val){
            $wordList = [];
            foreach ($val as $row){
                //return $row;
                array_push($wordList, $row->word);
            }
            $data['bcs'] = $key;
            $data['wordList'] = $wordList;
            array_push($bcsDataset, $data);
        }
        //return $bcsDataset;
        Storage::disk('public')->put('bcs_questions.json', json_encode($bcsDataset));



        $obj  = PreviousJobExams::where('exam', '!=', 'BCS')
            //->orderBy('year', 'desc')
            ->get()
            ->groupBy('year');
        //return $obj;
        $bankDataset = []; $wordList = []; $data = [];
        $lastXmPostY = ""; $lastExam = ""; $lastPostName = ""; $lastYear = "";
        foreach ($obj as $year=>$rows){
            foreach ($rows as $row){
                //return $row;
                $xmPostY = $row->exam.'-'.$row->post_name.'-'.$row->year;
                if($lastXmPostY != $xmPostY){
                    if(sizeof($wordList)>0){
                        sort($wordList);
//                        echo $lastXmPostY." - ".'<br>';
//                        echo implode(", ", $wordList).'<hr>';

                        $data['bank'] = $lastExam;
                        $data['postName'] = $lastPostName;
                        $data['year'] = $lastYear;
                        $data['wordList'] = $wordList;
                        array_push($bankDataset, $data);

                        $wordList = [];
                    }
                }

                array_push($wordList, $row->word);

                $lastXmPostY = $xmPostY;
                $lastExam = $row->exam;
                $lastPostName = $row->post_name;
                $lastYear = $row->year;
            }
        }

        sort($wordList);
//        echo $lastExam." - ".$lastPostName." - ".$lastYear.'<br>';
//        echo implode(", ", $wordList).'<hr>';
        $data['bank'] = $lastExam;
        $data['postName'] = $lastPostName;
        $data['year'] = $lastYear;
        $data['wordList'] = $wordList;
        array_push($bankDataset, $data);

        //return $bankDataset;
        Storage::disk('public')->put('bank_questions.json', json_encode($bankDataset));

//        $obj = PreviousJobExams::where('exam', '=', 'BCS')
//            ->where('word', 'not like', '% %')
//            ->get()
//            ->groupBy('word');
//        return count($obj);
//        $words = [];
//        foreach ($obj as $key=>$row){
//            $w = Words::where('word', $key)
//            ->whereNotNull('display_index')
//            ->get(['id']);
//            if(count($w)==0){
//                echo $key.' - ';
//                array_push($words, $key);
//            }
//        }
//        echo "<p>".(count($words))." words</p>";
    }







    function wordsmartWords(){
        $words = ["ABASH","ABATE","ABDICATE","ABERRATION","ABHOR","ABJECT","ABNEGATE","ABORTIVE","ABRIDGE","ABSOLUTE","ABSOLVE","ABSTINENT","ABSTRACT","ABSTRUSE","ABYSMAL","ACCOLADE","ACCOST","ACERBIC","ACQUIESCE","ACRID","ACRIMONIOUS","ACUMEN","ACUTE","ADAMANT","ADDRESS","ADHERENT","ADMONISH","ADROIT","ADULATION","ADULTERATE","ADVERSE","AESTHETIC","AFFABLE","AFFECTATION","AFFINITY","AFFLUENT","AGENDA","AGGREGATE","AGNOSTIC","AGRARIAN","ALACRITY","ALLEGE","ALLEVIATE","ALLOCATE","ALLOY","ALLUSION","ALOOF","ALTRUISM","AMBIENCE","AMBIGUOUS","AMBIVALENT","AMELIORATE","AMENABLE","AMENITY","AMIABLE","AMNESTY","AMORAL","AMOROUS","AMORPHOUS","ANACHRONISM","ANALOGY","ANARCHY","ANECDOTE","ANGUISH","ANIMOSITY","ANOMALY","ANTECEDENT","ANTIPATHY","ANTITHESIS","APARTHEID","APATHY","APHORISM","APOCALYPSE","APOCRYPHAL","APOTHEOSIS","APPEASE","APPRECIATE","APPREHENSIVE","APPROBATION","APPROPRIATE","APTITUDE","ARBITER","ARBITRARY","ARCANE","ARCHAIC","ARCHETYPE","ARDENT","ARDUOUS","ARISTOCRATIC","ARTFUL","ARTIFICE","ASCENDANCY","ASCETIC","ASSIDUOUS","ASSIMILATE","ASSUAGE","ASTUTE","ATHEIST","ATTRITION","AUDACITY","AUGMENT","AUSPICIOUS","AUSTERE","AUTOCRATIC","AUTONOMOUS","AVARICE","AVOW","AVUNCULAR","AWRY","AXIOM","BANAL","BANE","BASTION","BEGET","BELABOR","BELEAGUER","BELIE","BELITTLE","BELLIGERENT","BEMUSED","BENEFACTOR","BENEVOLENT","BENIGN","BEQUEST","BEREAVED","BESET","BLASPHEMY","BLATANT","BLIGHT","BLITHE","BOURGEOIS","BOVINE","BREVITY","BROACH","BUCOLIC","BUREAUCRACY","BURGEON","BURLESQUE","CACOPHONY","CADENCE","CAJOLE","CALLOW","CANDOR","CAPITALISM","CAPITULATE","CAPRICIOUS","CARICATURE","CASTIGATE","CATALYST","CATEGORICAL","CATHARSIS","CATHOLIC","CAUSTIC","CELIBACY","CENSURE","CEREBRAL","CHAGRIN","CHARISMA","CHARLATAN","CHASM","CHASTISE","CHICANERY","CHIMERA","CHOLERIC","CHRONIC","CHRONICLE","CIRCUITOUS","CIRCUMLOCUTION","CIRCUMSCRIBE","CIRCUMSPECT","CIRCUMVENT","CIVIL","CLEMENCY","CLICHE","CLIQUE","COALESCE","COERCE","COGENT","COGNITIVE","COGNIZANT","COHERENT","COLLOQUIAL","COLLUSION","COMMENSURATE","COMPELLING","COMPENDIUM","COMPLACENT","COMPLEMENT","COMPLICITY","COMPREHENSIVE","COMPRISE","CONCILIATORY","CONCISE","CONCORD","CONCURRENT","CONDESCEND","CONDONE","CONDUCIVE","CONFLUENCE","CONGENIAL","CONGENITAL","CONGREGATE","CONJECTURE","CONJURE","CONNOISSEUR","CONSECRATE","CONSENSUS","CONSONANT","CONSTRUE","CONSUMMATE","CONTENTIOUS","CONTIGUOUS","CONTINGENT","CONTRITE","CONTRIVED","CONVENTIONAL","CONVIVIAL","COPIOUS","COROLLARY","CORROBORATE","COSMOPOLITAN","COUNTENANCE","COUP","COVENANT","COVERT","COVET","CREDULOUS","CRITERION","CRYPTIC","CULINARY","CULMINATE","CULPABLE","CURSORY","CURTAIL","CYNIC","DAUNT","DEARTH","DEBACLE","DEBAUCHERY","DEBILITATE","DECADENT","DECIMATE","DECOROUS","DEDUCE","DEFAME","DEFERENCE","DEFINITIVE","DEGENERATE","DELETERIOUS","DELINEATE","DELUDE","DELUGE","DEMAGOGUE","DENIZEN","DEPRAVITY","DEPRECATE","DERIDE","DEROGATORY","DESICCATE","DESPONDENT","DESPOT","DESTITUTE","DESULTORY","DEXTROUS","DIALECTICAL","DICTUM","DIDACTIC","DIFFIDENT","DIGRESS","DILETTANTE","DISCERN","DISCREET","DISCRETE","DISCRIMINATE","DISDAIN","DISINTERESTED","DISPARAGE","DISPARATE","DISSEMINATE","DISSIPATE","DISSOLUTION","DISTEND","DISTINGUISH","DOCILE","DOCTRINAIRE","DOGMATIC","DOMESTIC","DORMANT","DUBIOUS","DUPLICITY","EBULLIENT","ECCENTRIC","ECLECTIC","EDIFY","EFFACE","EFFUSION","EGALITARIAN","EGOCENTRIC","EGREGIOUS","ELICIT","ELLIPTICAL","ELUSIVE","EMIGRATE","EMINENT","EMPIRICAL","EMULATE","ENCROACH","ENDEMIC","ENERVATE","ENFRANCHISE","ENGENDER","ENIGMA","ENORMITY","EPHEMERAL","EPIGRAM","EPITOME","EQUANIMITY","EQUITABLE","EQUIVOCAL","ERUDITE","ESOTERIC","ESPOUSE","ETHEREAL","EUPHEMISM","EVANESCENT","EXACERBATE","EXACTING","EXALT","EXASPERATE","EXEMPLIFY","EXHAUSTIVE","EXHORT","EXIGENCY","EXISTENTIAL","EXONERATE","EXPATRIATE","EXPEDIENT","EXPEDITE","EXPLICIT","EXTOL","EXTRANEOUS","EXTRAPOLATE","EXTRICATE","EXTROVERT","EXULT","FABRICATION","FACETIOUS","FACILE","FACTION","FARCICAL","FASTIDIOUS","FATALIST","FATUOUS","FAUNA","FECUND","FELICITY","FERVOR","FETTER","FIDELITY","FIGURATIVE","FINESSE","FLAGRANT","FLAUNT","FLOUT","FOIBLE","FOMENT","FORBEAR","FOREGO","FORSAKE","FORTUITOUS","FOUNDER","FRATERNAL","FRENETIC","FRUGAL","FURTIVE","FUTILE","GARRULOUS","GAUCHE","GENRE","GENTEEL","GESTICULATE","GLUT","GRANDILOQUENT","GRANDIOSE","GRATUITOUS","GRAVITY","GREGARIOUS","GUILE","HACKNEYED","HAPLESS","HARBINGER","HEDONISM","HEGEMONY","HERESY","HERMETIC","HEYDAY","HIATUS","HIERARCHY","HISTRIONIC","HOMILY","HOMOGENEOUS","HUSBANDRY","HYPERBOLE","HYPOTHETICAL","ICONOCLAST","IDEOLOGY","IDIOSYNCRASY","IDYLLIC","IGNOMINY","ILLICIT","IMMIGRATE","IMMINENT","IMMUTABLE","IMPARTIAL","IMPECCABLE","IMPERIAL","IMPERVIOUS","IMPETUOUS","IMPLEMENT","IMPOTENT","IMPUGN","INANE","INAUGURATE","INCANDESCENT","INCANTATION","INCENSE","INCESSANT","INCIPIENT","INCISIVE","INCONGRUOUS","INCORRIGIBLE","INCREMENT","INDIFFERENT","INDIGENOUS","INDIGENT","INDIGNANT","INDOLENT","INDULGENT","INEFFABLE","INEPT","INERT","INEXORABLE","INFAMOUS","INFATUATED","INFER","INFINITESIMAL","INGENUOUS","INHERENT","INJUNCTION","INNATE","INNOCUOUS","INORDINATE","INSATIABLE","INSIDIOUS","INSINUATE","INSIPID","INSOLENT","INSTIGATE","INSULAR","INSURGENT","INTEGRAL","INTEGRATE","INTRACTABLE","INTRANSIGENT","INTRINSIC","INTROSPECTIVE","INUNDATE","INVECTIVE","INVETERATE","IRASCIBLE","IRONIC","IRREVOCABLE","ITINERANT","JUDICIOUS","JUXTAPOSE","KINETIC","LABYRINTH","LACONIC","LAMENT","LAMPOON","LANGUISH","LARGESS","LATENT","LAUD","LEGACY","LETHARGY","LEVITY","LIBEL","LITIGATE","LOQUACIOUS","LUCID","LUGUBRIOUS","LUMINOUS","MACHINATION","MAGNANIMOUS","MAGNATE","MALAISE","MALFEASANCE","MALIGNANT","MALINGER","MALLEABLE","MANDATE","MANIFEST","MANIFESTO","MARSHAL","MARTIAL","MARTYR","MATRICULATE","MAUDLIN","MAVERICK","MAXIM","MEDIATE","MELLIFLUOUS","MENDACIOUS","MENDICANT","MENTOR","MERCENARY","MERCURIAL","METAMORPHOSIS","MICROCOSM","MILIEU","MINUSCULE","MISANTHROPIC","MITIGATE","MOLLIFY","MONOLITHIC","MORIBUND","MOROSE","MORTIFY","MUNDANE","MUNIFICENT","MYOPIA","MYRIAD","NARCISSISM","NEBULOUS","NEFARIOUS","NEOLOGISM","NEPOTISM","NIHILISM","NOMINAL","NOSTALGIA","NOTORIOUS","NOVEL","NOXIOUS","NUANCE","OBDURATE","OBFUSCATE","OBLIQUE","OBLIVION","OBSCURE","OBSEQUIOUS","OBTUSE","OFFICIOUS","ONEROUS","OPAQUE","OPULENT","ORTHODOX","OSTENSIBLE","OSTENTATIOUS","PACIFY","PAINSTAKING","PALLIATE","PALPABLE","PALTRY","PANACEA","PARADIGM","PARADOX","PAROCHIAL","PARODY","PARSIMONIOUS","PARTISAN","PATENT","PATERNAL","PATHOLOGY","PATRIARCH","PATRICIAN","PATRONIZE","PAUCITY","PECCADILLO","PEDANTIC","PEDESTRIAN","PEJORATIVE","PENCHANT","PENITENT","PENSIVE","PEREMPTORY","PERENNIAL","PERFIDY","PERFUNCTORY","PERIPATETIC","PERIPHERY","PERJURY","PERMEATE","PERNICIOUS","PERQUISITE","PERTINENT","PERTURB","PERUSE","PERVADE","PETULANT","PHILANTHROPY","PHILISTINE","PIOUS","PIVOTAL","PLACATE","PLAINTIVE","PLATITUDE","PLEBEIAN","PLETHORA","POIGNANT","POLARIZE","POLEMIC","PONDEROUS","PORTENT","POSTULATE","PRAGMATIC","PRECEDENT","PRECEPT","PRECIPITATE","PRECIPITOUS","PRECLUDE","PRECURSOR","PREDILECTION","PREEMINENT","PREEMPT","PREMISE","PREPOSSESS","PREROGATIVE","PREVAIL","PRISTINE","PRODIGAL","PRODIGIOUS","PRODIGY","PROFANE","PROFESS","PROFICIENT","PROFLIGATE","PROFOUND","PROFUSE","PROLETARIAT","PROLIFERATE","PROLIFIC","PROMULGATE","PROPENSITY","PROPITIOUS","PROPONENT","PROPRIETARY","PROPRIETY","PROSAIC","PROSCRIBE","PROSELYTIZE","PROTAGONIST","PROTRACT","PROVIDENT","PROVINCIAL","PROVISIONAL","PROXIMITY","PRUDENT","PURPORTED","PUTATIVE","QUALIFY","QUALITATIVE","QUERULOUS","QUIXOTIC","RAMIFICATION","RANCOR","RAPACIOUS","REBUKE","REBUT","RECALCITRANT","RECANT","RECIPROCAL","RECLUSIVE","RECONDITE","RECRIMINATION","REDOLENT","REDUNDANT","REFUTE","REITERATE","RELEGATE","RELENTLESS","RELINQUISH","REMONSTRATE","RENAISSANCE","RENOUNCE","REPARATION","REPERCUSSION","REPLENISH","REPLETE","REPREHENSIBLE","REPRISAL","REPROACH","REPROVE","REPUDIATE","REQUISITE","RESOLUTE","RESPITE","RETICENT","REVERE","RHETORIC","RIGOROUS","ROBUST","ROGUE","RUDIMENTARY","RUMINATE","RUSTIC","SACCHARINE","SACRILEGE","SACROSANCT","SAGACIOUS","SALIENT","SALUTARY","SANCTIMONIOUS","SANGUINE","SARDONIC","SCINTILLATE","SCRUPULOUS","SCRUTINIZE","SECULAR","SEDITION","SEGREGATE","SENSORY","SENTIENT","SEQUESTER","SERENDIPITY","SERVILE","SINGULAR","SINISTER","SLANDER","SLOTH","SOBRIETY","SOLICITOUS","SOLVENT","SOPORIFIC","SORDID","SPAWN","SPECIOUS","SPORADIC","SPURIOUS","SQUALOR","SQUANDER","STAGNATION","STATIC","STAUNCH","STEADFAST","STIGMATIZE","STIPULATE","STOIC","STRATUM","STRICTURE","STRIFE","STRINGENT","STYMIE","SUBJUGATE","SUBLIME","SUBORDINATE","SUBSTANTIVE","SUBTLE","SUBVERSIVE","SUCCINCT","SUCCUMB","SUPERCILIOUS","SUPERFICIAL","SUPERFLUOUS","SURFEIT","SURREPTITIOUS","SURROGATE","SYCOPHANT","SYNTHESIS","TACIT","TACITURN","TANGENTIAL","TANGIBLE","TANTAMOUNT","TAUTOLOGICAL","TEMERITY","TEMPERATE","TENABLE","TENACIOUS","TENET","TENTATIVE","TENUOUS","TERSE","THEOLOGY","TIRADE","TORPOR","TOUCHSTONE","TOUT","TRANSCEND","TRANSGRESS","TRANSIENT","TREPIDATION","TURPITUDE","UBIQUITOUS","UNCONSCIONABLE","UNCTUOUS","UNIFORM","UNREMITTING","UNWITTING","URBANE","USURP","UTILITARIAN","UTOPIA","VACILLATE","VAPID","VEHEMENT","VENAL","VENERATE","VERACITY","VERBOSE","VERISIMILITUDE","VERNACULAR","VESTIGE","VEX","VIABLE","VICARIOUS","VICISSITUDE","VILIFY","VINDICATE","VINDICTIVE","VIRTUOSO","VIRULENT","VISIONARY","VITIATE","VITRIOLIC","VOCATION","VOCIFEROUS","VOLATILE","VOLITION","WANTON","WILLFUL","WISTFUL","ZEALOUS","ABASE","ABET","ABEYANCE","ABJURE","ABOMINATION","ABORIGINAL","ABOUND","ABROGATE","ACCEDE","ACCENTUATE","ACCESS","ACCLAIM","ACCORD","ACCOUTERMENTS","ACCRUE","ACQUISITIVE","ACQUIT","ACRONYM","ADAGE","ADDUCE","ADJOURN","ADJUNCT","AD-LIB","ADVENT","ADVENTITIOUS","ADVOCATE","AFFIDAVIT","AFFILIATE","AFFLICTION","AFFORD","AFFRONT","AFTERMATH","AGGRANDIZE","AGGRIEVE","AGHAST","ALCHEMY","ALIENATE","ALLEGIANCE","ALLEGORY","ALLOT","ALTERCATION","AMASS","AMID","ANATHEMA","ANCILLARY","ANGST","ANNEX","ANNUITY","ANTEDATE","ANTERIOR","ANTHOLOGY","ANTHROPOMORPHIC","ANTIPODAL","ANTIQUITY","APERTURE","APEX","APOGEE","APOPLEXY","APOSTASY","APPALLING","APPARITION","APPELLATION","APPENDAGE","APPORTION","APPOSITE","APPRAISE","APPRISE","APPURTENANCE","APROPOS","APT","ARCADE","ARCHIPELAGO","ARCHIVES","ARID","ARMAMENT","ARMISTICE","ARRAIGN","ARRANT","ARREARS","ARSENAL","ARTICULATE","ARTISAN","ASCERTAIN","ASCRIBE","ASKANCE","ASPERSION","ASSAIL","ASSERT","ASSESS","ASTRINGENT","ASYLUM","ATONE","ATROPHY","ATTEST","ATTRIBUTE","AUGUR","AUGUST","AUSPICES","AUXILIARY","AVAIL","AVANT-GARDE","AVERSION","AVERT","AVID","BACCHANAL","BALEFUL","BALK","BALLYHOO","BALM","BANDY","BANTER","BAROQUE","BARRAGE","BAUBLE","BEDLAM","BEGRUDGE","BEHEST","BEMOAN","BENEDICTION","BENIGHTED","BESTOW","BILIOUS","BIVOUAC","BLANCH","BLAND","BLANDISHMENT","BLISS","BLUSTER","BOMBAST","BON VIVANT","BONA FIDE","BOON","BOOR","BOOTY","BOTCH","BRACING","BRANDISH","BRAVADO","BRAWN","BRAZEN","BREACH","BRINK","BRISTLE","BROMIDE","BROUHAHA","BRUSQUE","BUFFOON","BULWARK","BYZANTINE","CABAL","CACHE","CALAMITY","CALLOUS","CALUMNY","CANON","CANT","CANVASS","CAPACIOUS","CAPITAL","CAPTIVATE","CARCINOGENIC","CARDINAL","CAREEN","CARTOGRAPHY","CASCADE","CATACLYSM","CAUCUS","CAVALIER","CAVIL","CHAFF","CHAMELEON","CHAMPION","CHANNEL","CHASTE","CHERUB","CHORTLE","CHURL","CHUTZPAH","CIPHER","CIRCUMNAVIGATE","CITADEL","CLANDESTINE","CLASSIC","CLEAVE","CLIMATIC","CLOISTER","CLONE","CLOUT","CLOY","CODDLE","COGITATE","COHORT","COMMEMORATE","COMMISERATE","COMMODIOUS","COMPATIBLE","COMPETENT","COMPILE","COMPLY","COMPOSED","COMPROMISE","COMPUNCTION","CONCAVE","CONCEDE","CONCENTRIC","CONCERT","CONCOCT","CONCOMITANT","CONFEDERATE","CONFER","CONFIDANT","CONFIGURATION","CONFLAGRATION","CONFLUENCE","CONFOUND","CONGEAL","CONJUGAL","CONNIVE","CONSERVATORY","CONSIGN","CONSOLIDATE","CONSPICUOUS","CONSTERNATION","CONSTITUENCY","CONTEMPT","CONTINUUM","CONTRABAND","CONTRETEMPS","CONTUMELY","CONUNDRUM","CONVENE","CONVERSANT","CONVERSE","CONVEY","CONVICTION","CONVOLUTION","COPIOUS","CORDIAL","COROLLARY","CORPOREAL","CORRELATION","CORROSIVE","CORRUGATED","COTERIE","COWER","CRASS","CRAVEN","CRESCENDO","CRESTFALLEN","CREVICE","CRINGE","CRITIQUE","CRUX","CUISINE","CULL","CURB","CURMUDGEON","CURSORY","DEBASE","DEBUNK","DECREE","DECRY","DEEM","DEFICIT","DEFILE","DEFT","DEFUNCT","DEGRADE","DEIGN","DEITY","DEJECTED","DELECTABLE","DELINQUENT","DELVE","DEMEANOR","DEMISE","DEMOGRAPHY","DEMUR","DEMURE","DENOMINATION","DENOTE","DENOUNCE","DEPICT","DEPLETE","DEPLORE","DEPLOY","DEPOSE","DEPREDATE","DERELICT","DESIST","DEVOUT","DIATRIBE","DICHOTOMY","DIFFUSE","DILAPIDATED","DILATE","DILEMMA","DIMINUTION","DIRE","DIRGE","DISAFFECT","DISARRAY","DISCLAIM","DISCOMFIT","DISCONCERT","DISCOURSE","DISCREPANCY","DISCURSIVE","DISGRUNTLE","DISINFORMATION","DISMAL","DISMAY","DISPASSIONATE","DISPERSE","DISPIRIT","DISPOSITION","DISPROPORTIONATE","DISQUIET","DISSEMBLE","DISSENT","DISSERVICE","DISSIDENT","DISSUADE","DISTINCT","DIURNAL","DIVINE","DIVULGE","DOCUMENT","DOLDRUMS","DOLEFUL","DOLT","DOTAGE","DOUBLE ENTENDRE","DOUR","DOWNCAST","DOWNPLAY","DRACONIAN","DROLL","DROSS","DURESS","EBB","ECCLESIASTICAL","ECLIPSE","ECOSYSTEM","EDICT","EDIFICE","EFFECTUAL","EFFICACY","EFFIGY","ELATION","ELECTORATE","ELEGY","ELITE","ELOCUTION","EMACIATE","EMANATE","EMANCIPATE","EMBARGO","EMBELLISH","EMBODY","EMBROIL","EMBRYONIC","EMISSARY","EMPATHY","EMPOWER","ENDEAR","ENGAGING","ENMITY","ENNUI","ENSUE","ENTAIL","ENTITY","ENTREAT","ENTREPRENEUR","ENUMERATE","ENVISION","EPICURE","EPILOGUE","EPOCH","EQUESTRIAN","ESTIMABLE","ESTRANGE","ETHICS","EULOGY","EVINCE","EVOKE","EXCISE","EXEMPT","EXHUME","EXODUS","EXORBITANT","EXPIATE","EXPLICATE","EXPOSITION","EXPOSTULATE","EXPUNGE","EXQUISITE","EXTANT","EXTORT","EXTREMITY","EXUBERANT","FACADE","FACET","FALLACY","FATHOM","FAUX","FAWN","FEIGN","FESTER","FETISH","FIASCO","FIAT","FICKLE","FIGMENT","FISCAL","FLEDGLING","FLIPPANT","FLORID","FODDER","FOLLY","FORAY","FOREBODE","FORECLOSE","FORENSIC","FORESTALL","FORSWEAR","FORTE","FORTHRIGHT","FOSTER","FRAGMENTARY","FRUITFUL","FUEL","FULMINATE","GAFFE","GALVANIZE","GAMBIT","GAMUT","GARNER","GASTRONOMY","GENERIC","GENESIS","GENOCIDE","GERMANE","GHASTLY","GRATIS","GRIEVOUS","GRIMACE","GUISE","HABITUATE","HALCYON","HARASS","HARBINGER","HARP","HARRY","HEINOUS","HERALD","HOARY","HOMAGE","HUBRIS","HYPOCRISY","IDIOM","IMBUE","IMPASSE","IMPEACH","IMPECUNIOUS","IMPEDE","IMPENDING","IMPENETRABLE","IMPERATIVE","IMPETUOUS","IMPLICATION","IMPORTUNE","IMPOVERISH","IMPREGNABLE","IMPRESARIO","IMPROMPTU","IMPROVISE","IMPUNITY","INADVERTENT","INALIENABLE","INCARNATION","INCENDIARY","INCLINATION","INCULCATE","INCUMBENT","INCURSION","INDICT","INDUCE","INELUCTABLE","INERADICABLE","INFLAMMATORY","INFLUX","INFRACTION","INFRASTRUCTURE","INFRINGE","INFUSE","INGRATIATE","INIMICAL","INIMITABLE","INNUENDO","INQUISITION","INSOUCIANT","INSUFFERABLE","INSUPERABLE","INSURRECTION","INTEGRAL","INTERIM","INTERLOPER","INTERLUDE","INTERMINABLE","INTERMITTENT","INTERSPERSE","INTERVENE","INTIMATE","INTRICATE","INTRIGUE","INVIDIOUS","INVIOLATE","INVOKE","IRIDESCENT","JARGON","JAUNT","JINGOISM","JOCULAR","JUBILATION","JUNCTION","JUNTA","KARMA","LARCENY","LASCIVIOUS","LAVISH","LAX","LAYMAN","LIAISON","LICENTIOUS","LIMPID","LISTLESS","LITANY","LIVID","LOATH","LOBBY","LOUT","LUDICROUS","LYRICAL","MALAPROPISM","MANIA","MARGINAL","MATERIALISTIC","MAWKISH","MEANDER","MEDIUM","MELANCHOLY","MELEE","MENAGERIE","METICULOUS","MILLENNIUM","MIRE","MODE","MODULATE","MOMENTUM","MORATORIUM","MORES","MOTIF","MOTLEY","MUNICIPAL","MUSE","MUSTER","MYSTIC","NEBULOUS","NEMESIS","NEOPHYTE","NIRVANA","NOISOME","NOMADIC","NOMENCLATURE","NONCHALANT","NULLIFY","OBEISANCE","OBJECTIVE","OBTRUSIVE","OBVIATE","OCCULT","ODIOUS","ODYSSEY","OLFACTORY","OLIGARCHY","OMINOUS","OMNISCIENT","OPPROBRIOUS","ORDINANCE","OSCILLATE","OSMOSIS","OSTRACIZE","OUST","OVERRIDE","OVERTURE","OXYMORON","PALATABLE","PALLOR","PANDEMIC","PANEGYRIC","PARABLE","PARAGON","PARALLEL","PARANOIA","PARANORMAL","PAROXYSM","PARTITION","PASTORAL","PATHOS","PATINA","PATRIMONY","PECULIAR","PEREGRINATION","PERPETRATOR","PERPETUATE","PERVERSE","PHANTASM","PHLEGMATIC","PILGRIMAGE","PLACEBO","PLATONIC","PLAUSIBLE","PLIABLE","PLIGHT","PLUNDER","PLURALISM","PONTIFICATE","POROUS","POSTERITY","POSTHUMOUS","POSTURE","PRATTLE","PRECARIOUS","PRECOCIOUS","PREDECESSOR","PREDICAMENT","PREDISPOSE","PREDOMINANT","PREGNANT","PRELUDE","PREMEDITATED","PREPONDERANCE","PRESAGE","PRESENTIMENT","PRESUMABLY","PRESUPPOSE","PRIMAL","PRISTINE","PRIVATION","PROCLAIM","PROCURE","PROGENY","PROPAGATE","PROPOUND","PROTEGE","PROTOCOL","PROVOCATION","PROWESS","PRURIENT","PSEUDONYM","PSYCHE","PUMMEL","PUNCTILIOUS","PUNDIT","PUNGENT","PUNITIVE","PURBLIND","PURITANICAL","QUAINT","QUANDARY","QUASI","QUAY","QUELL","QUERY","QUEUE","QUIESCENT","QUINTESSENTIAL","QUIZZICAL","QUOTIDIAN","RAMPANT","RAPTURE","RAREFIED","RATIFY","RATIOCINATION","RATIONALE","RAUCOUS","REACTIONARY","REBUFF","RECIDIVISM","RECLAIM","REDEEM","REDRESS","REFERENDUM","REFRACTORY","REGIME","REGIMEN","REMISSION","REMUNERATION","REND","RENDER","REPARTEE","REPLICATE","REPOSE","REPRESS","REPRIMAND","REPRISAL","REPROBATE","REPUGNANT","RESIGNATION","RESPLENDENT","RESURRECTION","RETORT","RETROSPECT","REVAMP","REVEL","REVILE","REVULSION","RHAPSODIZE","RIBALD","RIFE","RIVET","ROUT","RUE","SALLY","SALUTATION","SANCTION","SARCASM","SAVANT","SCANT","SCHISM","SCORN","SEAMLESS","SECEDE","SECLUSION","SECT","SEDENTARY","SELF-MADE","SENTENTIOUS","SERENE","SERPENTINE","SHACKLE","SHIBBOLETH","SHREWD","SINGULAR","SKIRMISH","SKITTISH","SLAKE","SOLACE","SOLIDARITY","SOPHOMORIC","SORDID","SOVEREIGN","SPATE","SPECIOUS","SPECTER","SPECTRUM","SPURN","STALWART","STARK","STINT","STIPEND","STOLID","STOUT","STRATAGEM","STUPENDOUS","STUPOR","SUBSIDE","SUBSIDIARY","SUBSIDIZE","SUBSTANTIATE","SUBTERFUGE","SUFFICE","SUFFRAGE","SUFFUSE","SUMPTUOUS","SUPERSEDE","SUPINE","SUPPLICATION","SUPPRESS","SURMISE","SURREAL","SUSCEPTIBLE","SWEEPING","SYNTAX","SYSTEMIC","TACTICAL","TAINT","TEDIUM","TEEM","TEMPORAL","TEMPORIZE","TEPID","THESIS","THORNY","THRESHOLD","THROTTLE","THWART","TIMOROUS","TITILLATE","TITULAR","TOIL","TORTUOUS","TOXIC","TRANSFIX","TRAUMA","TRAVESTY","TRENCHANT","TRIUMVIRATE","TRYST","TUMULT","TURBID","TURMOIL","UNCANNY","UNDERLYING","UNDERMINE","UNDERPINNING","UNDERSCORE","UNDERWRITE","UNILATERAL","USURY","VACUOUS","VAGARY","VANQUISH","VENEER","VERDANT","VERGE","VERITY","VIE","VIGILANT","VIGNETTE","VISCOUS","VIVACIOUS","VOGUE","VOLUMINOUS","VOLUPTUOUS","VORACIOUS","WAFT","WAIVE","WAKE","WANE","WARRANT","WARY","WIZENED","WOE","WRATH","ZEITGEIST","ZENITH"];
        return $words;
    }






    /* if want to post something that shouldn't be repeated in future, then post it from page manually.
       All types listed below can be repeated in future, albeit not essential
    */
    use SocialMediaPostContents;
    public function postInfbPageJobVocabulary(Request $request){
        $postType = 'words';
        $myAuthKey = "belekana"; //coming request should have this key, otherwise it is likely to be unauthorized
        if($request->input('authKey') != $myAuthKey) return abort('403'); //as it will be called from API, we don't require admin login. just 'authKey' has to bet set in url

        $postingHelper = new FacebookPagePostingHelper();
        $contentToPost = $postingHelper->processContentSelection($postType);
        $additionalData = [];

        /* post content that can be fetched directly from hardcoded array are simply handled. But contents need to be dynamically generated are customized */
        if($postType == 'words'){
            //$contentToPost gives us only the word. Now data associated with this word has to be queried
            $word = $contentToPost;
            $readableContent = $postingHelper->wordDetailsReadableContent($word);
            $contentToPost = $readableContent; //newly processed content has been assigned

            $additionalData['word'] = $word;
        }



        return $postingHelper->postInJovoc($contentToPost, $additionalData);

    }












}
