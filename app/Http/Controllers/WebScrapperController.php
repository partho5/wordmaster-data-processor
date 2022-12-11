<?php

namespace App\Http\Controllers;

use App\Models\Words;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use SimpleXMLElement;

class WebScrapperController extends Controller
{


    function dailyStarScrapper(Request $request){
        ini_set("max_execution_time", 3000000);
        set_time_limit(3000000);

        if($request->has('s')){
            sleep($request->s * 60);
        }

        $start = round(microtime(true)*1000);

        $path = storage_path()."/app/public/dailyStar/log.json";
        $log = json_decode(file_get_contents($path));
        $lastNewsDate = $log->last_date;

        $c=0;
        for($y=2010;$y<=2019;$y++){
            for($m=1;$m<=12;$m++){
                for($d=1;$d<=31;$d++){
                    $mm = $m<=9 ? '0'.$m : $m;
                    $dd = $d<=9 ? '0'.$d : $d;
                    $date = $y.'-'.$mm.'-'.$dd;
                    //echo $c.' >>> '.$date.'  ---- '.$m.'/'.$d.'<br>';

                    if($date>$lastNewsDate){
                        $oneDayJson = $this->getJsonFor($date);
                        if( empty(json_decode($oneDayJson, true)) ){
                            echo 'empty json';
                        }else{
                            //return $oneDayJson;
                            //Storage::disk('public')->put('/dailyStar/'.$date.'.json', $oneDayJson );
                            Storage::disk('public')->put('/dailyStar/log.json', json_encode([
                                'last_date' => $date
                            ]) );
                            $dropboxSaveName="dailyStar/".$date.".json";
                            Storage::disk('dropbox')->put($dropboxSaveName, $oneDayJson);

                            $end = round(microtime(true)*1000);
                            echo "<hr> ".(($end-$start)/1000)." <hr>";
                            return;
                        }
                    }
                }
            }
        }
    }



    function getJsonFor($date){

        $headings =  $this->extractAllHeadings($date);

        $todayData = [];

        $i=0;
        foreach ($headings as $heading){
            //$heading = '<h5><a href="/frontpage/bangladesh-nicrh-icu-in-sickbed-1848325">ICU on sickbed </a></h5>';
            $news = $this->getNews($heading);
            $headline = $news['headline'];
            $url = $news['url'];
            $newsBody = $this->extractNewsBody($url);

            array_push($todayData, [
                'headline'  => $headline,
                'url'       => $url,
                'newsDetails'   => $newsBody
            ]);

            //echo "<p>".$news['headline']." => ".$news['url']." <br> ".$newsBody." </p>";
            //echo "<p>".$news['headline']." => ".$news['url']."</p>";
            //if($i++>2) break;
        }


        $todayJson = json_encode($todayData);
        return $todayJson;
    }



    function extractNewsBody($url){
        //$url = "https://www.thedailystar.net/in-focus/news/purbabanga-rangabhumi-and-the-beginning-theatre-dhaka-1849873";

        $content = '';
        try{
            $page = file_get_contents($url);
            $doc = new DOMDocument();

            // set error level
            $internalErrors = libxml_use_internal_errors(true);

            $doc->loadHTML($page);

            // Restore error level
            libxml_use_internal_errors($internalErrors);

            $xpath = new DomXPath($doc);
            $nodeList = $xpath->query("//div[@class='node-content']");
            try{
                $node = $nodeList->item(0);
                try{
                    $content = $node->nodeValue;
                }catch (\Exception $e){
                    //dd($url);
                }
            }catch (\Exception $e){
                //dd($url);
            }
            //echo $content;
        }catch (\Exception $e){}

        return $content;
    }



    function getNews($h5Html){
        $headline = "";
        $href="";

        try{
            preg_match('/<h5>(.*?)<\/h5>/s', $h5Html, $match);
            $head = $match[0];
            //echo $head;

            $head = str_replace("<h5>", "", $head);
            $a = $head = str_replace("</h5>", "", $head);

            $a = new SimpleXMLElement($a);
            $href = "https://www.thedailystar.net".$a['href'];
            //echo $href;

            str_replace("<a>", "", $a);
            $headline = str_replace("</a>", "", $a);

            //echo "<br>".$headline."<hr>";
        }catch (\Exception $e){

        }

        return [
            'headline'  => $headline,
            'url'       => $href
        ];
    }



    function extractAllHeadings($date){
        $url = "https://www.thedailystar.net/newspaper?date=$date";
        $allHeadingsDom = [];

        try{
            $page = file_get_contents($url);
            $doc = new DOMDocument();

            // set error level
            $internalErrors = libxml_use_internal_errors(true);

            $dom = $doc->loadHTML($page);

            // Restore error level
            libxml_use_internal_errors($internalErrors);

            $headings = $doc->getElementsByTagName('h5');

            $xpath = new DOMXPath($doc);
            $xpath_resultset =  $xpath->query("//h5");

            $len = $xpath_resultset->length;
            for($i=0;$i<$len;$i++){
                $htmlString = $doc->saveHTML($xpath_resultset->item($i));
                //echo $htmlString."<br>";
                array_push($allHeadingsDom, $htmlString);
            }
        }catch (\Exception $e){}

        return $allHeadingsDom;
    }



    function insertNews(){
        ini_set("max_execution_time", 3000000);
        set_time_limit(3000000);

        $path = storage_path()."/app/public/dailyStar/log.json";
        $log = json_decode(file_get_contents($path));
        $lastNewsDate = $log->last_insert_date;

        $c=0;
        for($y=2017;$y<=2020;$y++) {
            for ($m = 1; $m <= 12; $m++) {
                for ($d = 1; $d <= 31; $d++) {
                    $mm = $m <= 9 ? '0' . $m : $m;
                    $dd = $d <= 9 ? '0' . $d : $d;
                    $date = $y . '-' . $mm . '-' . $dd;

                    if ($date > $lastNewsDate) {
                        try{
                            $x = Storage::disk('dropbox')->exists("/dailyStar/$date.json");
                            if($x){
                                $file = Storage::disk('dropbox')->get("/dailyStar/$date.json");
                                $json = json_decode($file, true);
                                foreach ($json as $news){
                                    DB::connection('misc')
                                        ->insert("INSERT INTO `news`( `newspaper`, `topic`, `headline`, `url`, `news_details`, `news_date`) VALUES(?, ?, ?, ?, ?, ?)",
                                            ["dailyStar", null, $news['headline'], $news['url'], $news['newsDetails'], $date ] );
                                }
                                Storage::disk('public')->put('/dailyStar/log.json', json_encode([
                                    'last_insert_date' => $date
                                ]) );
                                if(++$c>10) return 'done upto '.$date;
                            }
                        }catch(\Exception $e){}
                    }
                }
            }
        }
    }


    function t(){
        DB::connection('misc')
            ->insert("INSERT INTO `news`( `newspaper`, `topic`) VALUES(?, ?)",
                ["ds", "business page"] );
        $news = DB::connection('misc')->select("select * from news");
        return $news;
    }


}
