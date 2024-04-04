@extends('admin.base_layout')

@section('title')
    <title>App Upgrade Instructions</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/app_upgrade_instruction.css">


    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">
    <!-- https://fonts.google.com/specimen/Monda?query=monda -->
@endsection

@section('body_container')
    <div class="col-md-12 text-center no-padding">
        <h2 class="text-center">App Upgrade Instructions</h2>
        <h4 class="text-center alert">ALERT : Every click is consequential here !</h4>

        <div class="col-md-6 col-md-offset-3 col-xs-12 commands">
            <div class="col-md-4 col-xs-12 command">
                <a href="/question_bank/data/import/banks/prev_year_questions" target="_blank">Import Bank Words</a>
                <div class="about">
                    Words are kept in <br> <span>storage\app\private\
                        bank_question_words_json</span>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 command">
                <a href="/mobile/exportForAndroid" target="_blank">Export Words + Q</a>
                <div class="about">
                    json will be saved in <br> <span>storage\app\private\
                        word_data_for_android</span>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 command">
                <a href="/mobile_app/data/export/prev_year_questions" target="_blank">Export Question Bank</a>
                <div class="about">
                    json will be saved in <br> <span>storage\app\private\
                        word_data_for_android</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3 col-xs-12 android-steps text-left">
            <hr>
            <p class="text-center">In Android Studio</p>
            <hr>
            <ul>
                <li>
                    Click <strong>Export Words + Q</strong> above
                </li>
                <li>
                    <strong>How to add new data to the app</strong>
                    <ul>
                        <li>Place the word-containing .json files and <code>bank_questions_with_bangla_meaning.json</code> and <code>bcs_questions_with_bangla_meaning.json</code> from storage/app/private/word_data_for_android into the assets folder of the Android app.</li>
                        <li>Check the <code>numOfWordAssetFile</code> variable value. Also, check the last word ID in the last text file. Accordingly, set the <code>lastWordIdInAssetFiles</code> variable in MainActivity. You can get help from JSON format, query helper (<a href="https://jsoneditoronline.org/#left=local.bizoxi" target="_blank">https://jsoneditoronline.org/#left=local.bizoxi</a>).</li>
                        <li>Set <code>isTesting = true;</code> (Development mode).</li>
                        <li>Comment out the <code>.createFromAsset("database/wordmaster.db")</code> line in DatabaseClient.java.</li>
                        <li>In the Manifest file, uncomment permissions for storage.</li>
                        <li>Uninstall the app from the phone.</li>
                        <li>Install the app and allow storage permission.</li>
                        <li>Wait until all data gets inserted. Don't perform any activity; doing so will insert log data in the .db file which is to be shipped with the app.</li>
                        <li>Exit the app.</li>
                        <li>Open the app. This time the database will be exported as <code>wordmaster.db</code> in the Android directory of the phone.</li>
                        <li>Copy this <code>wordmaster.db</code> file to the assets/database directory. Do NOT rename the .db file.</li>
                        <li>Move all the .json files from the assets directory to somewhere else (such as: My Drive\devResource\vocabulary_data\json txt word data for Android).</li>
                        <li>Uncomment the <code>.createFromAsset("database/wordmaster.db")</code> line in DatabaseClient.java. Set the proper .db file name in <code>createFromAsset</code> the same as the file in the assets directory.</li>
                        <li>In the Manifest file, comment out permissions for storage.</li>
                        <li>Set <code>isTesting = false;</code> (Production mode).</li>
                        <li>Upgrade version code in app/build.gradle.</li>
                        <li>Uninstall the app.</li>
                        <li>Install it on your device and test the app.</li>
                        <li>Now you can Build > Generate a signed bundle in Android Studio.</li>
                    </ul>
                </li

        </div>

    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection