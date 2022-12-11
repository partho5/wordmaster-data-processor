@extends('admin.base_layout')

@section('title')
    <title>Admin Home</title>
@endsection

@section('external_resources')
    <link href="/css/admin/index.css" rel="stylesheet">
@endsection

@section('body_container')
    <div class="col-md-4" id="not-used" style="display: none;">
        <h4 class="text-center">Not used words</h4>
        <div class="words-wrapper"></div>
    </div>

    <div class="col-md-4 col-xs-12 no-padding">
        <div class="word-body col-xs-12 no-padding">
            <h3 class="text-center" id="heading1">Add new word</h3>
            <button id="prevBtn" prev-id="">Prev</button>
            <button id="nextBtn" next-id="">Next</button>
            <span style="display: none" id="clickedBtn"></span>
            <div class="col-xs-12 no-padding" id="base-word-wrapper">
                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12 vcenter">
                        Base word 
                        <button id="save-btn-tmp" class="vcenter" title="ctrl + S" style="padding: 0 1em;margin-left: 2em; color: #ff8800">Save</button> 
                        <span>id: </span>
                        <span id="wid"></span>
                        <span id="di"></span>
                    </label>
                    <div class="col-xs-10 vcenter">
                        <input type="text" class="form-control" id="base-word" value="">
                    </div>
                    <div class="col-xs-1 vcenter search-btn" title="ctrl + F"><img src="/images/icon/search_btn_blue.png" width="20px" height="20px"></div>

                    <div class="col-xs-12 hidden" id="base-or-derived">
                        <div class="col-xs-6 no-padding">
                            <input type="checkbox" id="base"> Base word
                        </div>
                        <div class="col-xs-6 no-padding">
                            <input type="checkbox" id="derived"> Derived word
                        </div>
                    </div>
                </div>


                <div class="col-xs-12  field-wrapper" id="pronunciation-wrapper">
                    <label class="col-xs-12 no-padding">Pronunciation</label>
                    <textarea id="pronunciation" class="form-control"></textarea>
                </div>


                <div class="col-xs-12  field-wrapper" id="importance-wrapper">
                    <div class="col-xs-6 no-padding ">
                        <label style="margin-top: 6px">Importance Level</label>
                        <a href="#synonym-wrapper">Synonym div</a>
                        &nbsp;&nbsp;&nbsp;&nbsp; <a href="#usage-wrapper">Examples</a>
                        &nbsp;&nbsp;&nbsp;&nbsp; <a href="#word-note-wrapper">Note</a>
                    </div>
                    <div class="col-xs-6 no-padding ">
                        <select class="form-control" id="importance_level">
                            @for($i=90; $i >= 40; $i-=5)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper hidden" id="category-wrapper">
                    <div class="heading">Categories</div>

                    <div id="categories">
                        @foreach($wordCategories as $key=>$val)
                            <div class="col-xs-6 category"><input type="checkbox" value="{{ $val }}"> {{ $key }} </div>
                        @endforeach
                    </div>

                    <script>
                        var wordCategoryNames = []; var wordCategoryValues = [];
                        var checkedCategoryValues = [];
                    </script>
                    @foreach($wordCategories as $key=>$val)
                        <script>
                            wordCategoryNames.push("{{ $key }}");
                            wordCategoryValues.push("{{ $val }}");
                        </script>
                    @endforeach
                </div>

                <div class="col-xs-12 no-padding field-wrapper" id="word-meaning">
                    <label for="" class="col-xs-12">Bangla meaning</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Parts of speech</label>
                    <div class="col-xs-12" id="parts-of-speech">
                        <div class="col-xs-6 no-padding">
                            <select name="" id="pof1" class="form-control">
                                <option value="" selected>Not specified</option>
                                @foreach($partsOfSpeech as $pof)
                                    <option value="{{ $pof }}">{{ $pof }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-6 no-padding">
                            <select name="" id="pof2" class="form-control">
                                <option value="" selected>Not specified</option>
                                @foreach($partsOfSpeech as $pof)
                                    <option value="{{ $pof }}">{{ $pof }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper" id="word-note-wrapper">
                    <label for="" class="col-xs-12">Word note</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="word-note" rows="4" class="form-control" style="font-size: 1.3em;"></textarea>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 no-padding" id="mnemonic-wrapper">
                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Mnemonic</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="mnemonic" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Mnemonic note</label>
                    <div class="col-xs-12 tetarea-container">
                        <textarea name="" id="mnemonic-note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 no-padding" id="derivation-wrapper">
                <label for="" class="col-xs-12">Derived words ।</label>
                <div class="col-xs-12 no-padding field-wrapper" id="derived-words">
                    <div class="col-xs-12 no-padding dword-wrapper">
                        <div class="col-xs-6">
                            <input type="text" class="form-control" value="">
                        </div>
                        <div class="col-xs-1 search-btn no-padding">search</div>
                        <div class="col-xs-5">
                            <select name="" id="how-related" class="form-control">
                                <option value="" selected>Not specified</option>
                                @foreach($partsOfSpeech as $pof)
                                    <option value="{{ $pof }}">{{ $pof }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Derivation note</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="derivation-note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>



            



            <div class="col-xs-12 no-padding" id="antonym-wrapper">
                <label for="" class="col-xs-12">Antonyms</label>

                <div class="col-xs-12 no-padding field-wrapper" id="antonyms">

                    <div class="col-xs-12 no-padding anto-wrap">
                        <div class="col-xs-10 anto-input-wrapper">
                            <input type="text" class="form-control" style='background-color:rgba(247, 0, 0, 0.15)'>
                        </div>
                        <div class="col-xs-2 search-btn">search</div>
                    </div>

                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Antonym note</label>
                    <div class="col-xs-12 textarea-container">
                        <p style="color: red">Not implemented yet</p>
                        <textarea name="" id="antonym-note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>



            <div class="col-xs-12 no-padding" id="usage-wrapper">
                <a href="#synonym-wrapper">Synonym div</a>
                &nbsp;&nbsp;&nbsp;&nbsp; <a href="#heading1">Top</a>
                <div class="col-xs-12 no-padding field-wrapper" id="usage">
                    <label for="" class="col-xs-12">Usage</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Usage note</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="usage-note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>



            <div class="col-xs-12 no-padding" id="synonym-wrapper">
                <label for="" class="col-xs-12">Synonyms</label>
                <a href="#usage-wrapper">Examples</a>
                &nbsp;&nbsp;&nbsp;&nbsp; <a href="#heading1">Top</a>
                <div class="col-xs-12 no-padding field-wrapper" id="synonyms">
                    <div class="col-xs-12 no-padding syno-wrap">
                        <div class="col-xs-10 syno-input-wrapper">
                            <input type="text" class="form-control" style='background-color:rgba(247, 0, 0, 0.15)'>
                        </div>
                        <div class="col-xs-2 search-btn">search</div>
                    </div>
                </div>

                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Synonym note</label>
                    <div class="col-xs-12 textarea-container">
                        <p style="color: red">Not implemented yet</p>
                        <textarea name="" id="synonym-note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>



            <div class="col-xs-12 no-padding" id="confusing-wrapper">
                <br> <br>
                <a href="#usage-wrapper">Examples</a>
                &nbsp;&nbsp;&nbsp;&nbsp; <a href="#heading1">Top</a>
                &nbsp;&nbsp;&nbsp;&nbsp; <a href="#synonym-wrapper">Synonym div</a>
                <div class="col-xs-12 no-padding field-wrapper">
                    <label for="" class="col-xs-12">Don't confuse with</label>
                    <div class="col-xs-12 textarea-container">
                        <textarea name="" id="confusing-hint" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>


            <div class="col-xs-12 no-padding" id="">
                <div id="popup1-wrapper">
                    <div id="popup1" class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 text-center">Saved !</div>
                </div>


                <div class="col-xs-8 col-xs-offset-2" id="save-btn-wrapper">
                    <button class="btn btn-success form-control" id="save-btn">Save</button>
                </div>
            </div>
        </div>


        <div class="col-xs-12 no-padding" id="bangla-search-container">
            <h5 class="text-center"> <span>বাংলা অনুসন্ধান</span> </h5>
            <div class="xol-xs-12 no-padding">
                <div class="col-xs-6">
                    <input type="text" id="bangla-text" value="" class="form-control" placeholder="বাংলা শব্দ">
                </div>
                <div class="col-xs-6">
                    <span class="icon src-icon col-xs-1" id=""> <img src="/images/icon/search_btn_blue.png" alt="search"> </span>
                    <span class="icon clr-icon col-xs-1" id=""> <img src="/images/icon/clear_text.webp" alt="clear"> </span>
                </div>
            </div>

            <div class="search-results col-xs-12 no-padding">
                <div class="result col-xs-12">
                    <div class="col-xs-8 bangla">bangla</div>
                    <a class="col-xs-4 english" target="_blank">english</a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')

    <script src="/js/nice_edit.js" type="text/javascript"></script>
    <script src="/js/tone.js" type="text/javascript"></script>
    <script src="/js/admin/index.js" type="text/javascript"></script>

    {{--<script src="https://www.gstatic.com/firebasejs/8.4.2/firebase-app.js" type="text/javascript"></script>--}}
    {{--<script src="https://www.gstatic.com/firebasejs/8.4.2/firebase-auth.js"></script>--}}
	{{--<script src="https://www.gstatic.com/firebasejs/8.4.2/firebase-database.js"></script>--}}
	{{--<script src="https://www.gstatic.com/firebasejs/8.4.2/firebase-messaging.js" type="text/javascript"></script>--}}

<script>
    $(document).ready(function () {


    	

    	
    	var firebaseConfig = {
    	    apiKey: "AIzaSyCK5exxxxxxxxxxxxxxxxN2mTRuI",
    	    authDomain: "home-autoxxxxxxx8d.firebaseapp.com",
    	    databaseURL: "https://homexxxxxxx8d.firebaseio.com",
    	    projectId: "homxxxxxxxd",
    	    storageBucket: "home-xxxxxxxxd.appspot.com",
    	    messagingSenderId: "56xxxxxx84",
    	    appId: "1:56xxxx584:web:58xxxxxxxx1c5",
    	    measurementId: "G-VG3xxxxZEP"
    	  };
    	  // Initialize Firebase
//    	  firebase.initializeApp(firebaseConfig);
//
//        var ref = firebase.database().ref("home-xxxxxxxxx2a8d");

//        firebase.database().ref().child("wordmaster").child("page_update").child("admin").child("last_saved_word").on('value', function(snapshot) {
//            //admin > get last saved word here
//            var activeWord = snapshot.val();
//            p("last saved word "+activeWord);
//            //$('#base-word').val(activeWord);
//        });
//
//        firebase.database().ref().child("wordmaster").child("page_update").child("admin").child("updated_at").on('value', function(snapshot) {
//            //admin > word save btn clicked
//            $('.search-btn').click(); //just refresh, with changing word to favor *searching* a word only at one device
//            p("updated at "+snapshot.val());
//
////            Object.keys(obj).forEach(function(key) {
////                console.log(key+" => "+obj[key]);
////            });
//        });
//
//        firebase.database().ref().child("wordmaster").child("page_update").child("admin").child("active_word").on('value', function(snapshot) {
//            //admin > next btn clicked, get active word here
//            var activeWord = snapshot.val();
//            p("next clicked. active "+activeWord);
//            $('#base-word').val(activeWord);
//            $('.search-btn').click();
//        });



        bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
                new nicEditor({
                    fullPanel : true
                }).panelInstance(
                    document.getElementById('word-note')
                )
            );
        });

        bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
                new nicEditor({
                	fullPanel : true
                }).panelInstance(
                    document.getElementById('mnemonic')
                )
            );
        });


        if( ! $("#base-word").val() ){
            $("#base-word").val( getCookie("currentWord") );
        }
        setTimeout(function () {
            $("#base-word-wrapper .search-btn").click();
        }, 50);

        //location.hash = "parameter1=DEF&parameter2=XYZ";


//        var url = new URL(url_string);
//        var c = url.searchParams.get("c");
//        console.log(c);

        $('body').on("click", "#word-meaning textarea:last-child" , function () {
            //console.log(emptyFieldCount("#word-meaning textarea"));
            if( emptyFieldCount("#word-meaning textarea") < 2 ){
                $("<textarea name=\"\" id=\"\" rows=\"3\" class=\"form-control\" style='display: none'></textarea>").appendTo("#word-meaning .textarea-container").fadeIn();
            }
        });

        $('body').on("click", "#derivation-wrapper input:last-child" , function () {
            if( emptyFieldCount("#derivation-wrapper input") < 2 ){
                appendDerivationField();
            }
        });

        $('body').on("click", "#synonyms input:last-child" , function () {
            if( emptyFieldCount("#synonyms input") < 2 ){
                $("#synonyms").append("<div class=\"col-xs-12 no-padding syno-wrap\">\n" +
                    "                    <div class=\"col-xs-10 syno-input-wrapper\">\n" +
                    "                        <input type=\"text\" class=\"form-control\" style='background-color:rgba(247, 0, 0, 0.15)'>\n" +
                    "                    </div>\n" +
                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                    "                </div>");
            }
        });


        $('body').on("click", "#antonyms input:last-child" , function () {
            if( emptyFieldCount("#antonyms input") < 2 ){
                $("#antonyms").append("<div class=\"col-xs-12 no-padding anto-wrap\">\n" +
                    "                    <div class=\"col-xs-10 anto-input-wrapper\">\n" +
                    "                        <input type=\"text\" class=\"form-control\" style='background-color:rgba(247, 0, 0, 0.15)'>\n" +
                    "                    </div>\n" +
                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                    "                </div>");
            }
        });


        $('body').on("click", "#usage textarea:last-child" , function () {
            if( emptyFieldCount("#usage textarea") < 2 ){
                $("<textarea name=\"\" id=\"\" rows=\"2\" class=\"form-control\" style='display: none'></textarea>").appendTo("#usage .textarea-container").fadeIn();
            }
        });


        var baseOrDerived = [];
        baseOrDerived[0] = $("#base").is(":checked") ? 1 : 0;
        baseOrDerived[1] = $("#derived").is(":checked") ? 1 : 0;
        $("#base-or-derived #base").on("change", function () {
            if(confirm("Sure change this value ?")){
                baseOrDerived[0] = $(this).is(":checked") ? 1 : 0;
            }else{
                $(this).prop("checked", baseOrDerived[0]);
            }
        });
        $("#base-or-derived #derived").on("change", function () {
            if(confirm("Sure change this value ?")){
                baseOrDerived[1] = $(this).is(":checked") ? 1 : 0;
            }else{
                $(this).prop("checked", baseOrDerived[1]);
            }
        });

        $("#save-btn, #save-btn-tmp").click(function () {
            var baseWord = $("#base-word").val().trim();
            var pronunciation = $('#pronunciation').val().trim();
            var importanceLevel = $("#importance_level").val();
            baseOrDerived[0] = $("#base").is(":checked") ? 1 : 0;
            baseOrDerived[1] = $("#derived").is(":checked") ? 1 : 0;
            var banglaMeaning = [];
            $("#word-meaning textarea").each(function () {
                var meaningId = $(this).attr("meaning_id");
                var meaning = $(this).val().trim();
                if( meaningId || meaning ){
                    banglaMeaning.push({
                        'meaning_id': meaningId,
                        'bangla_meaning' : meaning
                    });
                }
            });

            var derivedWords = [];
            $(".dword-wrapper input").each(function () {
                var wordId = $(this).data("word_id");
                var dword = $(this).val().trim();
                var howRelated = $(this).parent().next().next().find('select').val();
                if( wordId ){
                    derivedWords.push({
                        'dword': dword,
                        'dword_id':wordId,
                        'how_related':howRelated
                    });
                }
            });

            var partsOfSpeech = [];
            $("#parts-of-speech select").each(function () {
                var pof_id = $(this).attr("pof_id");
                var pof_val = $(this).val();
                partsOfSpeech.push({
                    pof_id : pof_id,
                    pof_val : pof_val
                });
            });

            var wordNote = $("#word-note-wrapper").find('.nicEdit-main').html();
            var mnemonic = $("#mnemonic-wrapper").find('.nicEdit-main').html();
            var mnemonicNote = $("#mnemonic-note").val().trim();
            var derivationNote = $("#derivation-note").val().trim();


            var synonyms = [];
            $(".syno-input-wrapper input").each(function () {
                var synoId = $(this).attr("syno_id");
                var synonym = $(this).val().trim();
                //var take = $(this).parent().siblings().find('input').is(":checked") ? 1 : 0;
                if( synoId ){
                    synonyms.push({
                        'syno_id': synoId,
                        'syno_word' : synonym,
                        //'take'  : take
                    });
                }
            });
            var synoNote = $("#synonym-note").val().trim()



            var antonyms = [];
            $(".anto-input-wrapper input").each(function () {
                var antoId = $(this).attr("anto_id");
                var antonym = $(this).val().trim();
                if( antoId ){
                    antonyms.push({
                        'anto_id': antoId,
                        'anto_word' : antonym
                    });
                }
            });
            var antoNote = $("#antonym-note").val().trim();


            var uses = [];
            $("#usage textarea").each(function () {
                var usageId = $(this).attr("usage_id");
                var sentence = $(this).val().trim();
                if( usageId || sentence ){
                    uses.push({
                        'usage_id': usageId,
                        'sentence' : sentence
                    });
                }
            });
            var usageNote = $("#usage-note").val().trim();
            var confusingHint = $("#confusing-hint").val().trim();


            if(baseWord){
                $.ajax({
                    url : '/admin/ajax/save_word',
                    type : 'post',
                    async:true,
                    data : {
                        _token : "{{ csrf_token() }}", base_word : baseWord, pronunciation:pronunciation, bangla_meaning : banglaMeaning,
                        parts_of_speech : partsOfSpeech, word_note : wordNote, mnemonic : mnemonic,
                        mnemonic_note : mnemonicNote, derivation_note : derivationNote ,
                        usage : uses, usage_note : usageNote, base_or_derived : baseOrDerived,
                        derived_words : derivedWords, synonyms : synonyms, syno_note : synoNote,
                        antonyms : antonyms, anto_note : antoNote, importance_level : importanceLevel,
                        confusing_hint : confusingHint
                    }, success : function (response) {
                        p("ajax/save_word");
                        p(response);

                        if(response.hasOwnProperty('word')){
                            $("#importance_level").val(response['word']['importance_level']);
                        }

                        if(response['word'].hasOwnProperty('pronunciation')){
                            $("#pronunciation").val(response['word']['pronunciation']);
                            $("#pronunciation").hide().fadeIn();
                        }

                        if(response.hasOwnProperty('checked_categories')){
                            checkedCategoryValues = response['checked_categories'];
                        }else{
                            checkedCategoryValues = [];
                        }
                        refreshCategories(wordCategoryNames, wordCategoryValues, checkedCategoryValues);


                        if(response.hasOwnProperty('meanings')){
                            if(response['meanings'][0]){
                                //at least 1 meaning exist
                                $("#word-meaning .textarea-container textarea").remove();
                                for(var i in response['meanings']){
                                    $("<textarea name=\"\" meaning_id='"+(response['meanings'][i]['id'])+"' rows=\"3\" class=\"form-control\" style='display: none; font-size:1.3em'>"+(response['meanings'][i]['bangla_meaning'])+"</textarea>").appendTo("#word-meaning .textarea-container").fadeIn();
                                }
                            }
                        }



                        $('#pof1, #pof2').val("");//refresh value
                        for(var i in response['parts_of_speech']){
                            if( response['parts_of_speech'][i]['id'] ){
                                var id = parseInt(i)+1;
                                id = "#pof"+id;
                                $(id).val(response['parts_of_speech'][i]['parts_of_speech']);
                                $(id).attr("pof_id", response['parts_of_speech'][i]['id']);
                            }
                        }
                        $("#pof1, #pof2").hide().fadeIn();



                        $("#derived-words .dword-wrapper").remove();
                        appendDerivationField();
                        if(response.hasOwnProperty('derived')){
                            for(var i in response['derived']){
                                $("#derived-words ").append("<div class=\"col-xs-12 no-padding dword-wrapper\">\n" +
                                    "                    <div class=\"col-xs-6\">\n" +
                                    "                        <input type=\"text\" data-word_id='"+response['derived'][i]['dword_id']+"' value='"+response['derived'][i]['dword']+"' class=\"form-control\">\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-1 search-btn no-padding\">search</div>\n" +
                                    "                    <div class=\"col-xs-5\">\n" +
                                    "                        <select name=\"\" id=\"how-related\" class=\"form-control\">\n" +
                                    "                            <option value=\"\" selected>Not specified</option>\n" +
                                    "                            @foreach($partsOfSpeech as $pof)\n" +
                                    "                                <option value=\"{{ $pof }}\">{{ $pof }}</option>\n" +
                                    "                            @endforeach\n" +
                                    "                            <option value=\""+response['derived'][i]['how_related']+"\" selected>"+response['derived'][i]['how_related']+"</option>\n" +
                                    "                        </select>\n" +
                                    "                    </div>\n" +
                                    "                </div>");
                            }
                            //to improve showing process of selected option
                        }



                        if(0 && response.hasOwnProperty('synonyms')){
                            $(".syno-wrap").remove();
                            for(var i in response['synonyms']){
                                var importantClass = "";
                                if(response['synonyms'][i]['importance_level'] >= 90){
                                    importantClass = "most-important-syno";
                                }else if(response['synonyms'][i]['importance_level'] == 80){
                                    importantClass = "important-syno";
                                }

                                var checkedStatus = response['synonyms'][i]['take'] ? "checked":"";

                                $("#synonyms").append("<div class=\"col-xs-12 no-padding syno-wrap\">\n" +
                                    "                    <div class='col-xs-1 take'> <input type='checkbox' "+checkedStatus+"> </div>"+
                                    "                    <div class=\"col-xs-8 syno-input-wrapper "+importantClass+" \">\n" +
                                    "                        <input type=\"text\" class=\"form-control\" value='"+response['synonyms'][i]['synoword']+"' syno_id='"+response['synonyms'][i]['syno_id']+"' style='background-color:rgb(255,255,255)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-1 details-link data-word='"+response['synonyms'][i]['synoword']+"' \"><span href='/admin/tom?w="+response['synonyms'][i]['synoword']+"&minView=true' target='_blank'> <img src='/images/icon/eye1.jpg' alt='V'> </span></div>"+
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                            if(emptyFieldCount(".syno-wrap") == 0){
                                $("#synonyms").append("<div class=\"col-xs-12 no-padding syno-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 syno-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\"  style='background-color:rgb(247,0,0, 0.15)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                        }
                        $('#synonyms').hide().fadeIn(1000);



                        if(response.hasOwnProperty('antonyms')){
                            $(".anto-wrap").remove();
                            for(var i in response['antonyms']){
                                $("#antonyms").append("<div class=\"col-xs-12 no-padding anto-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 anto-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\" value='"+response['antonyms'][i]['antoword']+"' anto_id='"+response['antonyms'][i]['anto_id']+"' style='background-color:rgb(255,255,255)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                            if(emptyFieldCount(".anto-wrap") == 0){
                                $("#antonyms").append("<div class=\"col-xs-12 no-padding anto-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 anto-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\"  style='background-color:rgb(247,0,0, 0.15)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                        }




                        if(response.hasOwnProperty('notes')){
                            //$("#word-note").val(response['notes'][0]['word_note']).hide().fadeIn();
                            $("#word-note-wrapper").find('.nicEdit-main').html(response['notes'][0]['word_note']).hide().fadeIn();
                            $("#mnemonic-note").val(response['notes'][0]['mnemonic_note']).hide().fadeIn();
                            $("#derivation-note").val(response['notes'][0]['derivation_note']).hide().fadeIn();
                            $("#usage-note").val(response['notes'][0]['usage_note']).hide().fadeIn();
                        }else{
                            //$("#word-note").val("").hide().fadeIn();
                            $("#word-note-wrapper").find('.nicEdit-main').html("").hide().fadeIn();
                            $("#mnemonic-note").val("").hide().fadeIn();
                            $("#derivation-note").val("").hide().fadeIn();
                            $("#usage-note").val("").hide().fadeIn();
                        }

                        if(response.hasOwnProperty('confusing')){
                            $('#confusing-hint').val(response['confusing'][0]['hint']).hide().fadeIn();
                        }else{
                            $('#confusing-hint').val("").hide().fadeIn();
                        }




                        if(response.hasOwnProperty('uses')){
                            for(var i in response['uses']){
                                if(response['uses'][0]){
                                    //at least 1 uses exist
                                    //p("ex : "+response['uses'][i]['sentence']);
                                    $("#usage .textarea-container textarea").remove();
                                    for(var i in response['uses']){
                                        $("<textarea name=\"\" usage_id='"+(response['uses'][i]['id'])+"' rows=\"2\" class=\"form-control\" style='display: none'>"+(response['uses'][i]['sentence'])+"</textarea>").appendTo("#usage .textarea-container").fadeIn();
                                    }
                                }
                            }
                        }

                        showPopupMsg("success", "Successfully saved !");
                        playTingTone();

                    }, error : function (error) {
                        p(error);
                        showPopupMsg("error", "Oops ! error occurred");
                    }
                });//ajax
            }


        });//#save-btn click


        $('body').on('click', '.syno-wrap .take', function () {
            var synoWord = $(this).siblings().find('input').val();
            var synoId = $(this).siblings().find('input').attr('syno_id');
            var checkedStatus = $(this).find('input').is(':checked') ? 1:0;
            var THIS = $(this);
            //p("syno w "+synoWord+" - "+synoId+" - "+checkedStatus);
            $.ajax({
                url : '/admin/ajax/take-discard-syno',
                type:'post',
                data : {
                    _token : "{{ csrf_token() }}", synoId : synoId, wid : $('#wid').text(),
                    checkedStatus : checkedStatus
                }, success : function (response) {
//                    p("syno take or discard : ");
//                    p(response);
                    if(response == 'ok'){
                        $(THIS).hide().fadeIn();
                    }
                }, error : function (e) {
                    alert("error ! could not toggle status !");
                }
            });
        });


        var nextId, prevId;
        $("#base-word-wrapper .search-btn, #prevBtn, #nextBtn").on("click", function (e) {
            nextId = $("#nextBtn").attr('next-id');
            prevId = $("#prevBtn").attr('prev-id');

            $.ajax({
                url : '/admin/ajax/fetch_word',
                type : 'post',
                data : {
                    _token : "{{ csrf_token() }}", requested_word : $("#base-word").val(),
                    prevId : prevId, nextId : nextId, clickedBtn : e.target.id, id:new URLSearchParams(window.location.search).get('id'), minimalView:new URLSearchParams(window.location.search).get('minView')
                }, success : function (response) {
                    p("ajax/fetch_word");
                    p(response);
                    if(response.hasOwnProperty('word')){
                        //word exists
                        if(response['word'].hasOwnProperty('word')){
                            $("#base-word").val(response['word']['word']);
                            $("#importance_level").val(response['word']['importance_level']);
                            $("#wid").text(response['word']['id']);
                            $("#di").text("index:"+response['word']['display_index']);
                        }

                        if(response['word'].hasOwnProperty('pronunciation')){
                            $("#pronunciation").val(response['word']['pronunciation']);
                            $("#pronunciation").hide().fadeIn();
                        }

                        if(response.hasOwnProperty('meanings')){
                            $("#word-meaning .textarea-container textarea").remove();
                            for(var i in response['meanings']){
                                $("<textarea name=\"\" meaning_id='"+(response['meanings'][i]['id'])+"' rows=\"3\" class=\"form-control\" style='display: none; font-size:1.3em;'>"+(response['meanings'][i]['bangla_meaning'])+"</textarea>").appendTo("#word-meaning .textarea-container").fadeIn();
                            }
                        }else{
                            $("#word-meaning .textarea-container textarea").remove();
                            $("<textarea name=\"\" meaning_id='"+("")+"' rows=\"3\" class=\"form-control\" style='display: none'>"+("")+"</textarea>").appendTo("#word-meaning .textarea-container").fadeIn();
                        }

                        var checkVal = response['word']['is_base_word'];
                        checkVal = checkVal ? true : false;
                        $("#base-or-derived #base").prop("checked", checkVal);
                        checkVal = response['word']['is_derived_word'];
                        checkVal = checkVal ? true : false;
                        $("#base-or-derived #derived").prop("checked", checkVal);
                        $("#base-or-derived").hide().fadeIn();



                        $('#pof1, #pof2').val("");//refresh value
                        for(var i in response['parts_of_speech']){
                            if( response['parts_of_speech'][i]['id'] ){
                                var id = parseInt(i)+1;
                                id = "#pof"+id;
                                $(id).val(response['parts_of_speech'][i]['parts_of_speech']);
                                $(id).attr("pof_id", response['parts_of_speech'][i]['id']);
                            }
                        }
                        $("#pof1, #pof2").hide().fadeIn();


                        if(response.hasOwnProperty('checked_categories')){
                            checkedCategoryValues = response['checked_categories'];
                        }else{
                            checkedCategoryValues = [];
                        }
                        refreshCategories(wordCategoryNames, wordCategoryValues, checkedCategoryValues);


                        if(response.hasOwnProperty('mnemonic')){
                            //$("#mnemonic").val(response['mnemonic'][0]['mnemonic']).hide().fadeIn();
                            $("#mnemonic-wrapper").find('.nicEdit-main').html(response['mnemonic'][0]['mnemonic']).hide().fadeIn();
                        }else{
                            //$("#mnemonic").val("");
                            $("#mnemonic-wrapper").find('.nicEdit-main').html("");
                        }



                        $("#derived-words .dword-wrapper").remove();
                        appendDerivationField();
                        if(response.hasOwnProperty('derived')){
                            for(var i in response['derived']){
                                $("#derived-words ").append("<div class=\"col-xs-12 no-padding dword-wrapper\">\n" +
                                    "                    <div class=\"col-xs-6\">\n" +
                                    "                        <input type=\"text\" data-word_id='"+response['derived'][i]['dword_id']+"' value='"+response['derived'][i]['dword']+"' class=\"form-control\">\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-1 search-btn no-padding\">search</div>\n" +
                                    "                    <div class=\"col-xs-5\">\n" +
                                    "                        <select name=\"\" id=\"how-related\" class=\"form-control\">\n" +
                                    "                            <option value=\"\" selected>Not specified</option>\n" +
                                    "                            @foreach($partsOfSpeech as $pof)\n" +
                                    "                                <option value=\"{{ $pof }}\">{{ $pof }}</option>\n" +
                                    "                            @endforeach\n" +
                                    "                            <option value=\""+response['derived'][i]['how_related']+"\" selected>"+response['derived'][i]['how_related']+"</option>\n" +
                                    "                        </select>\n" +
                                    "                    </div>\n" +
                                    "                </div>");
                            }
                            //to improve showing process of selected option
                        }



                        if(response.hasOwnProperty('synonyms')){
                            $(".syno-wrap").remove();
                            for(var i in response['synonyms']){
                                var importantClass = "";
                                if(response['synonyms'][i]['importance_level'] >= 90){
                                    importantClass = "most-important-syno";
                                }else if(response['synonyms'][i]['importance_level'] == 80){
                                    importantClass = "important-syno";
                                }

                                var checkedStatus = response['synonyms'][i]['take'] ? "checked":"";

                                $("#synonyms").append("<div class=\"col-xs-12 no-padding syno-wrap\">\n" +
                                    "                    <div class='col-xs-1 take'> <input type='checkbox' "+checkedStatus+"> </div>"+
                                    "                    <div class='col-xs-8 syno-input-wrapper "+importantClass+"'>\n" +
                                    "                        <input type=\"text\" class='form-control' value='"+response['synonyms'][i]['synoword']+"' syno_id='"+response['synonyms'][i]['syno_id']+"' style='background-color:rgb(255,255,255)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-1 details-link data-word='"+response['synonyms'][i]['synoword']+"' \"><span href='/admin/tom?w="+response['synonyms'][i]['synoword']+"&minView=true' target='_blank'> <img src='/images/icon/eye1.jpg' alt='V'> </span></div>"+
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                            if(emptyFieldCount(".syno-wrap") == 0){
                                $("#synonyms").append("<div class=\"col-xs-12 no-padding syno-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 syno-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\"  style='background-color:rgb(247,0,0, 0.15)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                        }

                        $('#synonyms').hide().fadeIn(1000);



                        if(response.hasOwnProperty('antonyms')){
                            $(".anto-wrap").remove();
                            for(var i in response['antonyms']){
                                $("#antonyms").append("<div class=\"col-xs-12 no-padding anto-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 anto-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\" value='"+response['antonyms'][i]['antoword']+"' anto_id='"+response['antonyms'][i]['anto_id']+"' style='background-color:rgb(255,255,255)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                            if(emptyFieldCount(".anto-wrap") == 0){
                                $("#antonyms").append("<div class=\"col-xs-12 no-padding anto-wrap\">\n" +
                                    "                    <div class=\"col-xs-10 anto-input-wrapper\">\n" +
                                    "                        <input type=\"text\" class=\"form-control\"  style='background-color:rgb(247,0,0, 0.15)'>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"col-xs-2 search-btn\">search</div>\n" +
                                    "                </div>");
                            }
                        }



                        if(response.hasOwnProperty('notes')){
                            //$("#word-note").val(response['notes'][0]['word_note']).hide().fadeIn();
                            $("#word-note-wrapper").find('.nicEdit-main').html(response['notes'][0]['word_note']).hide().fadeIn();
                            $("#mnemonic-note").val(response['notes'][0]['mnemonic_note']).hide().fadeIn();
                            $("#derivation-note").val(response['notes'][0]['derivation_note']).hide().fadeIn();
                            $("#usage-note").val(response['notes'][0]['usage_note']).hide().fadeIn();
                        }else{
                            //$("#word-note").val("").hide().fadeIn();
                            $("#word-note-wrapper").find('.nicEdit-main').html("").hide().fadeIn();
                            $("#mnemonic-note").val("").hide().fadeIn();
                            $("#derivation-note").val("").hide().fadeIn();
                            $("#usage-note").val("").hide().fadeIn();
                        }


                        if(response.hasOwnProperty('confusing')){
                            $('#confusing-hint').val(response['confusing'][0]['hint']).hide().fadeIn();
                        }else{
                            $('#confusing-hint').val("").hide().fadeIn();
                        }

                        if(response.hasOwnProperty('uses')){
                            for(var i in response['uses']){
                                //p("ex : "+response['uses'][i]['sentence']);
                                if(response['uses'][0]){
                                    //at least 1 usage exist
                                    $("#usage .textarea-container textarea").remove();
                                    for(var i in response['uses']){
                                        $("<textarea name=\"\" usage_id='"+(response['uses'][i]['id'])+"' rows=\"3\" class=\"form-control\" style='display: none; font-size: 1.4em'>"+(response['uses'][i]['sentence'])+"</textarea>").appendTo("#usage .textarea-container").fadeIn();
                                    }
                                }
                            }
                        }else{
                            $("#usage .textarea-container textarea").remove();
                            $("<textarea name=\"\" usage_id='"+("")+"' rows=\"2\" class=\"form-control\" style='display: none'>"+("")+"</textarea>").appendTo("#usage .textarea-container").fadeIn();
                        }



                        if(response.hasOwnProperty('nextId')){
                            $("#nextBtn").attr("next-id", response['nextId']);
                            $("#nextBtn").text("Next "+response['nextId']);
                        }
                        if(response.hasOwnProperty('prevId')){
                            $("#prevBtn").attr("prev-id", response['prevId']);
                            $("#prevBtn").text("Prev "+response['prevId']);
                        }

                        setCookie("currentWord", response['word']['word']);
                        //p("getCookie(\"currentWord\") : "+getCookie("currentWord"));

                        var newUrl = (window.location.origin)+""+(window.location.pathname)+"?w="+response['word']['word'];
                        window.history.pushState('', '', newUrl);

                        $("#save-btn").text("Save");
                        $("#heading1").text("Edit this word");
                    }else{
                        $("#save-btn").text("Add this word");
                        $("#save-btn-tmp").hide();
                        $("#heading1").text("Add new word");
                    }

                    if(! isMobile()){
                        $('#not-used').show();
                        //loadWordsNotUsedInSentence();
                    }

                    //playTickTone();

                }, error : function (error) {
                    p(error);
                    showPopupMsg("error", "Oops ! error occurred");
                }
            });
        });//base-word blur()



        $(document).on('click', '.dword-wrapper .search-btn', function () {
            var THIS_INPUT = $(this).prev().find('input');
            var dword = THIS_INPUT.val().trim();
            $.ajax({
                url : '/admin/ajax/search-dword',
                type : 'post',
                data : {
                    _token: "{{ csrf_token() }}", dword : dword
                }, success: function (response) {
                    p("search dword response");
                    p(response);
                    THIS_INPUT.hide().fadeIn();
                    if(response){
                        try{
                            THIS_INPUT.data("word_id", response[0]['id']);
                            THIS_INPUT.parent().parent().find('select').val(response[0]['parts_of_speech']);
                            THIS_INPUT.css('background-color', '#fff');
                        }catch (e){
                            p("error @ search derived word "+response);
                        }
                    }else{
                        THIS_INPUT.data("word_id", "");
                        THIS_INPUT.css('background-color', 'rgba(247, 0, 0, 0.15)');
                    }
                }, error : function (e) {
                    p(e);
                }
            });
        });



        $(document).on('click', '.syno-wrap .search-btn', function () {
            var THIS_INPUT = $(this).prev().find('input');
            var synoWord = THIS_INPUT.val().trim();

            $.ajax({
                url : '/admin/ajax/search-syno-word',
                type : 'post',
                data : {
                    _token: "{{ csrf_token() }}", syno_word : synoWord
                }, success: function (response) {
                    //p("ajax/search-syno-word");
                    //p(response);
                    THIS_INPUT.hide().fadeIn();
                    if(response){
                        THIS_INPUT.attr("syno_id", response[0]['id']);
                        THIS_INPUT.css('background-color', '#fff');
                    }else{
                        THIS_INPUT.attr("syno_id", "");
                        THIS_INPUT.css('background-color', 'rgba(247, 0, 0, 0.15)');
                    }
                }, error : function (e) {
                    p(e);
                }
            });
        });



        $('body').on('click', '.syno-wrap .details-link', function () {
            var word = $(this).siblings('.syno-input-wrapper').find('input').val();
            $.ajax({
                url:'/admin/ajax/fetch-meanings', type:'post',
                data:{
                    _token:"{{ csrf_token() }}", word:word
                }, success:function (response) {
                    var meanings = "------- "+word+" ------\n";
                    for(var i in response){
                        meanings+= response[i]['bangla_meaning']+"\n\n";
                    }
                    alert(meanings);
                }
            });
        });



        $(document).on('click', '.anto-wrap .search-btn', function () {
            var THIS_INPUT = $(this).prev().find('input');
            var antoWord = THIS_INPUT.val().trim();

            $.ajax({
                url : '/admin/ajax/search-anto-word',
                type : 'post',
                data : {
                    _token: "{{ csrf_token() }}", anto_word : antoWord
                }, success: function (response) {
//                    p("ajax/search-anto-word");
//                    p(response);
                    THIS_INPUT.hide().fadeIn();
                    if(response){
                        THIS_INPUT.attr("anto_id", response[0]['id']);
                        THIS_INPUT.css('background-color', '#fff');
                    }else{
                        THIS_INPUT.attr("anto_id", "");
                        THIS_INPUT.css('background-color', 'rgba(247, 0, 0, 0.15)');
                    }
                }, error : function (e) {
                    p(e);
                }
            });
        });





        function showPopupMsg(msgType, msgText) {
            $("#popup1-wrapper").show();
            var showDuration = 300;
            if(msgType === "success"){
                $("#popup1").addClass('success-popup');
            }else if(msgType === "error"){
                $("#popup1").addClass('error-popup');
                showDuration = 1000;
            }

            $("#popup1").text(msgText).show(0).animate({
                bottom : '30%',
                opacity : 1
            }, 200, function () {
                setTimeout(function () {
                    $("#popup1-wrapper").fadeOut();
                }, showDuration);
                setTimeout(function () {
                    $("#popup1").css('bottom', "0").css('opacity', 0);
                    $("#popup1").removeClass('success-popup').removeClass('error-popup');
                }, showDuration*2);
            });
        }//showPopupMsg()


        function appendDerivationField(){
            $("#derived-words").append("<div class=\"col-xs-12 no-padding dword-wrapper\">\n" +
                "                    <div class=\"col-xs-6\">\n" +
                "                        <input type=\"text\"  class=\"form-control\" style='background-color:rgba(247, 0, 0, 0.15)'>\n" +
                "                    </div>\n" +
                "                    <div class=\"col-xs-1 search-btn no-padding\">search</div>\n" +
                "                    <div class=\"col-xs-5\">\n" +
                "                        <select name=\"\" id=\"how-related\" class=\"form-control\">\n" +
                "                            <option value=\"\" selected>Not specified</option>\n" +
                "                            @foreach($partsOfSpeech as $pof)\n" +
                "                                <option value=\"{{ $pof }}\">{{ $pof }}</option>\n" +
                "                            @endforeach\n" +
                "                        </select>\n" +
                "                    </div>\n" +
                "                </div>");
        }




        $(window).bind('keydown', function(event) {
        	var inputFieldActive = $('input, textarea').is(':focus');

            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                	//ctrl+s
                    event.preventDefault();
                    $("#save-btn").click();
                    break;
                case 'f':
                	//ctrl+f
                    event.preventDefault();
                    $("#base-word-wrapper .search-btn").click();
                    break;
                case 'g':
                    // event.preventDefault();
                    // alert('ctrl+g');
                    // break;
                }

                if(event.which == 8){
                    //ctrl+backspace
                    $('#base-word').val("");
                    $('#base-word').focus();

                }
            }
            else if(event.keyCode == 13){
                //Enter
                if($('#base-word').is(':focus')){
                    event.preventDefault();
                    $("#base-word-wrapper .search-btn").click();
                }
            }
            else if (event.keyCode == 37){
            	//alert("left arrow");
            	if(! inputFieldActive && !isMobile()){
            		//$("#prevBtn").click();
            	}
            }
            else if (event.keyCode == 39 && !isMobile()){
            	//alert("right arrow");
            	if(! inputFieldActive){
            		//$('#nextBtn').click(); 
            	}
            }
            else if (event.keyCode == 191){
                //alert("forward slash /");
                if(! inputFieldActive){
                    event.preventDefault();
                    $('#base-word').focus();
                }
            }
        });


        $(document).on('click', '.category input', function () {
            var category = $(this).val();
            var action = $(this).is(':checked') ? 'tick' : 'untick';
            var word = $("#base-word").val().trim()
            $.ajax({
                url : '/admin/ajax/save_word_category',
                type : 'post',
                data : {
                    _token : "{{ csrf_token() }}", word : word, category : category, action : action
                }, success : function (response) {
                    p(response);
                }, error : function (e) {
                    p("ajax/save_word_category : "+e);
                }
            });
        });
        
        
        function refreshCategories(wordCategoryNames, wordCategoryValues, checkedCategoryValues) {
//            p("word categories :");
//            p(wordCategoryNames);
//            p(wordCategoryValues);
//            p(checkedCategoryValues);
            $("#category-wrapper #categories").html("");
            var dom = "";
            for(var i in wordCategoryValues){
                dom = dom+ "<div class='col-xs-6 category'><input type='checkbox' value='"+wordCategoryValues[i]+"'> "+wordCategoryNames[i]+"</div>\n"
            }
            $("#category-wrapper #categories").html(dom);

            $("#categories .category input").each(function (i) {
                if(checkedCategoryValues != null){
                    if( checkedCategoryValues.indexOf(parseInt($(this).val())) > -1){
                        //checkedCategoryValues[] array contains wordCategoryValues[i]
                        $(this).prop('checked', true);
                    }
                }
            });
            $("#category-wrapper #categories").hide().fadeIn();
        }



        function randomInclusive(min, max) {
            return Math.floor( Math.random()* (max-min+1) +min );
        }

        function loadWordsNotUsedInSentence() {
            $('#not-used .words-wrapper').fadeOut();
            var dom = "";

            var fontColors = ["#ce27ac",
                "#db0429",
                "#d98d00",
                "#007abe",
                "#000",
                "#21c354",
                "#1f14d5"];

            if( $('#base-word').val() ){
            	$.ajax({
            	    url : '/admin/ajax/load_unused',
            	    type:'post',
            	    data:{
            	        _token:"{{ csrf_token() }}", showingWord : $('#base-word').val(),

            	    },
            	    success:function (response) {
            	        //p(response);
            	        for (var i in response){
            	            var word = response[i];
            	            var n = randomInclusive(0, fontColors.length-1);
            	            dom = dom + "<a class='word' style='color: "+fontColors[n]+"' href='/admin/tom?w="+word+"' target='_blank' >"+word+" </a>";
            	        }
            	        $('#not-used .words-wrapper').html(dom);
            	        $('#not-used .words-wrapper').fadeIn();
            	    }, error : function (err) {
            	        p(err);
            	    }
            	});
            }
        }




        var results = $('#bangla-search-container .search-results');
        var resultTemplate = results.html();
        $(document).find('#bangla-search-container .search-results').html('');

        $('#bangla-search-container .src-icon').click(function () {
            var banglaText = $('#bangla-search-container #bangla-text').val().trim();
            if(banglaText){
                $.ajax({
                    url : '/admin/ajax/fetch_word_by_bangla_meaning',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", banglaText : banglaText
                    }, success : function (response) {
//                    p(response);
//                    p(resultTemplate);
                        $(document).find('#bangla-search-container .search-results').html(''); // clearing again is necessary
                        var url = location.protocol + '//' + location.host + location.pathname;
                        for(var i in response){
                            results.append(resultTemplate);
                            $(document).find('#bangla-search-container').find('.result').eq(i).find('.bangla').text(response[i]['meaning']);
                            $(document).find('#bangla-search-container').find('.result').eq(i).find('.english').text(response[i]['word']);
                            $(document).find('#bangla-search-container').find('.result').eq(i).find('.english').attr('href', url+"?w="+response[i]['word']);

                        }
                    }, error : function (e) {
                        p("fetch_word_by_bangla_meaning ERR "+e);
                    }
                });
            }
        });

        $('#bangla-search-container .clr-icon').click(function () {
            $(document).find('#bangla-search-container .search-results').html('');
            $('#bangla-search-container #bangla-text').val('').focus();
        });




        function isMobile(){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                //this is mobile
                return true;
            }else{
                //this is PC
                return false;
            }
        }




        function p(data) {
            console.log(data);
        }
        function emptyFieldCount(selector) {
            var c=0;
            $(selector).each(function () {
                if( !$(this).val() ){
                    ++c;
                }
            });
            return c;
        }


        function setCookie(cookieName, cookieVal) {
            document.cookie = cookieName+"="+cookieVal+";expires=01 Jan 2100";
        }

        function getCookie(cookieName) {
            var nameEQ = cookieName + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
    });
</script>


@endsection