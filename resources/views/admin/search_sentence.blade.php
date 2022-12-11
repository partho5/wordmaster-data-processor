@extends('admin.base_layout')

@section('title')
    <title>Search Sentence</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/display_index.css">

    <style>
        .news{
            text-align: justify;
            border-top: 1px solid #dcdcdc;
            padding: 10px 0;
            font-size: 1.3em;
        }
        .headline{
            font-weight: bold;
        }
        .src-kword{
            background: #fffb33;
            padding: 1px 0 1px 3px;
        }
    </style>
@endsection

@section('body_container')
    <div class="col-md-12 text-center">
        <div class="col-md-8 col-md-offset-2 col-xs-12" style="border: 1px solid #e7e7e7; padding: 1em; margin-top: 1em">
            <div class="col-xs-12" >
                <div class="col-xs-6">Word to search</div>
                <div class="col-xs-6">
                    <input type="text" id="wordToSearch" class="form-control">
                </div>

                <button class="col-xs-8 col-xs-offset-2" id="src-btn" style="margin-top: 1em">Search</button>
            </div>

            <div class="col-xs-12" id="loader" style="display: none">
                <img src="/images/loader1.gif" alt="">
            </div>

            <div class="col-xs-12 no-padding" id="src-res-wrapper" style="margin-top: 1em">
                <div class="news hidden">
                    <p class="headline">fdkjn jkd nbkj gnnkg jnj</p>
                    <p class="details">dn ljnj rgnner kdnl <span class='src-kword'>knvkrunn</span> grg njng nergunrekg uerbugnerui buierbuire biureb guienb ui ugre ngiun</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#src-btn').click(function () {
                $('#loader').show();
                $('#src-res-wrapper').html("");
                var word = $('#wordToSearch').val().trim().toLowerCase();
                $.ajax({
                    type:'post',
                    url:'/admin/ajax/senSearch',
                    data:{
                        _token: "{{ csrf_token() }}", word:word
                    }, success:function (response) {
                        p(response);
                        var dom = "";
                        if(response.length>0){
                            for(var i in response){
                                var h = response[i]['headline'];
                                var d = response[i]['news_details'];
                                h = h.replaceAll(word, "<span class='src-kword'>"+word+"</span>");
                                d = d.replaceAll(word, "<span class='src-kword'>"+word+"</span>");
                                dom+= "<div class='news'>\n" +
                                    "                    <p class='headline'>"+h+"</p>\n" +
                                    "                    <p class='details'>"+d+"</p>\n" +
                                    "                </div>";
                            }
                        }else{
                            dom = "No result found";
                        }

                        $('#src-res-wrapper').html(dom);
                        $('#loader').hide();
                    }, error:function (e) {
                        p(e);
                        $('#src-res-wrapper').html("error : "+e);
                    }
                });
            });


            String.prototype.replaceAll = function(strReplace, strWith) {
                // See http://stackoverflow.com/a/3561711/556609
                var esc = strReplace.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var reg = new RegExp(esc, 'ig');
                return this.replace(reg, strWith);
            };


        });
    </script>
@endsection