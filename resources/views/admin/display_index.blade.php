@extends('admin.base_layout')

@section('title')
    <title>Admin Display Index</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/display_index.css">
@endsection

@section('body_container')
    <div class="col-md-12 text-center">
        <div class="col-md-4 col-md-offset-4 col-xs-12" style="border: 1px solid #ababab; padding: 1em; margin-top: 1em">
            <h2 class="text-center">Modify display index</h2>
            <div id="new-index-word" class="col-md-12 col-xs-12 no-padding">
                <div class="text-left"><label>Word to re-assign above</label></div>
                <div class="col-md-9 col-xs-9 no-padding vcenter"><input id="ni-word" type="text" class="form-control"></div>
                <div class="col-md-2 col-xs-2 vcenter"><img class="search-btn" src="/images/icon/search_btn_blue.png" alt=""></div>
            </div>

            <div id="reference-word" class="col-md-12 col-xs-12 no-padding">
                <div class="text-left"><label>Reference word</label></div>
                <div class="col-md-9 col-xs-9 no-padding vcenter"><input id="ref-word" type="text" class="form-control"></div>
                <div class="col-md-2 col-xs-2 vcenter"><img class="search-btn" src="/images/icon/search_btn_blue.png" alt=""></div>
            </div>

            <div id="save-wrapper" class="col-md-10 col-xs-12">
                <button class="btn btn-success form-control" id="save-btn">Save</button>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {

            $("#new-index-word .search-btn").click(function () {
                var niWord = $("#ni-word").val();
                var response = search(niWord);
                p(response);
                if(response){
                    $("#ni-word").data("ni_id", response['thisWord'][0]['id']);
                    $("#ni-word").hide().css('background-color', '#fff').fadeIn();

                    //suggest reference word
                    $("#ref-word").val(response['nextWord'][0]['word']);
                    $("#ref-word").data("ref_id", response['nextWord'][0]['id']).hide().fadeIn();
                }else{
                    $("#ni-word").data("ni_id", null);
                    $("#ni-word").hide().css('background-color', 'rgba(255, 0, 0, 0.2)').fadeIn();
                }
            });

            $("#reference-word .search-btn").click(function () {
                var refWord = $("#ref-word").val();
                var response = search(refWord);
                if(response){
                    $("#ref-word").data("ref_id", response['thisWord'][0]['id']);
                    $("#ref-word").hide().css('background-color', '#fff').fadeIn();
                }else{
                    $("#ref-word").data("ref_id", null);
                    $("#ref-word").hide().css('background-color', 'rgba(255, 0, 0, 0.2)').fadeIn();
                }
            });

            $("#save-btn").click(function () {
                var niWord = $("#ni-word").val();
                var refWord = $("#ref-word").val();
                reAssignIndex(niWord, refWord);
            });

            $(document).on('keyup', 'input', function () {
                $(this).css('background-color', 'rgba(255, 0, 0, 0.2)');
                $(this).data("display_index", null);
            });

            function search(word) {
                var result = null;
                $.ajax({
                    url : '/admin/ajax/display_index/search',
                    type : 'post',
                    async : false,
                    data : {
                        _token : "{{ csrf_token() }}", word : word
                    }, success : function (response) {
                        result = response;
                    }
                });
                return result;
            }

            function reAssignIndex(niWord, refWord) {
                $.ajax({
                    url : '/admin/ajax/display_index/re_assign',
                    type : 'post',
                    data : {
                        _token : "{{ csrf_token() }}", niWord : niWord, refWord : refWord
                    }, success : function (response) {
                        p("display_index/re_assign", response);
                        alert("Done !");
                    }
                });
            }
        });
    </script>
@endsection