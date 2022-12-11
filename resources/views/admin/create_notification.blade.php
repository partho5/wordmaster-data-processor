@extends('admin.base_layout')

@section('title')
    <title>Notification Manager</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/create_notific.css">
@endsection

@section('body_container')
    <div class="col-md-12 text-center">
        <h4> <span>Create Notification</span> </h4>
        <div id="notific-creator" class="col-md-8 col-md-offset-2" style="border: 1px solid #FFF">
            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right text-xs-left">Positive Button Text</div>
                <div class="col-md-6">
                    <input id="positiveBtnText" type="text" class="form-control" value="Yes">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Positive Button Link</div>
                <div class="col-md-6">
                    <input id="positiveBtnLink" type="text" class="form-control" value="http://wordmas.com">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Negative Button Text</div>
                <div class="col-md-6">
                    <input id="negativeBtnText" type="text" class="form-control" value="Close">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Negative Button</div>
                <div class="col-md-6">
                    <select id="negativeBtnAllowed" class="form-control">
                        <option value="1">Allowed</option>
                        <option value="0">Not allowed</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Self Dismiss After (second)</div>
                <div class="col-md-6">
                    <input id="selfDismissAfter" type="number" class="form-control" value="10" min="1">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Valid Till Date (MM/DD/YYYY)</div>
                <div class="col-md-6">
                    <input id="validTill" type="datetime-local" class="form-control">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">HTML Content</div>
                <div class="col-md-6">
                    <textarea id="htmlContent" rows="5" class="form-control">content</textarea>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Repeat Interval (hours)</div>
                <div class="col-md-6">
                    <input id="repeatInterval" type="number" class="form-control" value="5" min="0">
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Environment</div>
                <div class="col-md-6">
                    <select id="environment" class="form-control">
                        <option value="t">Testing</option>
                        <option value="p">Production</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 text-right">Extras (JSON)</div>
                <div class="col-md-6">
                    <textarea id="extras" rows="5" class="form-control">  {"type":"wake", "versionCode":"1", "environment":"test"}  </textarea>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button id="create-notific-btn" class="btn btn-primary">Create Notification</button>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#create-notific-btn').click(function () {
                var positiveBtnText = $('#positiveBtnText').val().trim();
                var positiveBtnLink = $('#positiveBtnLink').val().trim();
                var negativeBtnText = $('#negativeBtnText').val().trim();
                var negativeAllowed = $('#negativeBtnAllowed').val();
                var selfDismissAfter = $('#selfDismissAfter').val();
                var validTill = $('#validTill').val();
                if(validTill){
                    validTill = validTill.substring(0,10)+" "+validTill.substring(11,16);
                }
                //p("validTill "+validTill);
                var htmlContent = $('#htmlContent').val().trim();
                var repeatInterval = $('#repeatInterval').val();
                var environment = $('#environment').val();
                var extras = $('#extras').val().trim();

                var allSure = [];
                if(negativeAllowed == 0){
                    var r = prompt("Negative button disabled ! are you sure ?");
                    if(r === null){
                        //p('cancel clicked, so not sure');
                        allSure.push(0);
                    }else {
                        //this may be even an empty string
                        //p('ok clicked, so sure');
                        allSure.push(1);
                    }
                }
                if(environment == 'p'){
                    var r = prompt("Production environment is set ! sure ?");
                    if(r === null){
                        //p('cancel clicked, so not sure');
                        allSure.push(0);
                    }else {
                        //this may be even an empty string
                        //p('ok clicked, so sure');
                        allSure.push(1);
                    }
                }
//                p(allSure);
//                p(positiveBtnText+"--"+positiveBtnLink+"--"+negativeBtnText+"--"+negativeAllowed+"--"+autoDismiss+"--"+validTill+"--"+htmlContent+"--"+repeatInterval+"--"+environment+"--");
                if(allSure.includes(0)){
                    //at least one false found
                }else if(positiveBtnText && positiveBtnLink && negativeBtnText && negativeAllowed && selfDismissAfter && validTill && htmlContent && repeatInterval && environment){
                    //save
                    if(! negativeAllowed){
                        negativeBtnText = '';
                    }
                    $.ajax({
                        'url' : '/admin/notific/create',
                        type : 'post',
                        data : {
                            _token : "{{ csrf_token() }}", positiveBtnText:positiveBtnText, positiveBtnLink:positiveBtnLink,
                            negativeBtnText:negativeBtnText, negativeAllowed:negativeAllowed, selfDismissAfter:selfDismissAfter,
                            validTill:validTill, htmlContent:htmlContent, repeatInterval:repeatInterval,
                            environment:environment, extras : extras
                        }, success : function (response) {
                            p(response);
                            $("#create-notific-btn").after("<br>"+response);
                        }, error : function (e) {
                            p(e);
                        }
                    });
                }else{
                    alert('Empty field found');
                }
            });

            function p(d) {
                console.log(d);
            }
        });
    </script>
@endsection