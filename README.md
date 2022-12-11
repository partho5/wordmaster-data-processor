To process a lot of raw data about vocabulary I developed a web application which includes many editable fields for each word. Some fields have rich text editor. Finally the processed data is exported in .json format. <br>
<ul> 
Key points : 
    <li>User/admin can add or edit a word</li> 
    <li>User/admin can add/edit pronunciation of the word</li> 
    <li>User/admin can add/edit importance level of the word</li> 
    <li>User/admin can add/edit definition of the word</li> 
    <li>User/admin can add/edit parts of speech (one or more) of the word</li> 
    <li>User/admin can add/edit side note of the word</li> 
    <li>User/admin can add/edit mnemonic as well as mnemonic note about the word</li> 
    <li>User/admin can add/edit derived words as well as side note of the word</li> 
    <li>User/admin can search for existing synonym. add/edit synonym of the word</li> 
    <li>User/admin can search for existing antonym . Can add/edit antonym of the word</li> 
    <li>User/admin can search word to find sentences containing that word</li> 
    <li>To prevent data loss, whole database is backed up twice a day using <b>cron job</b> and save to dropbox using <b>dropbox API</b></li> 
</ul>
