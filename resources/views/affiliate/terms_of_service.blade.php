<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Affiliate Terms of Service</title>

    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>

    <style>
        h3{
            color: #00acc8;
        }
        .most{
            padding: 1em 8px;
            background-color: rgba(0, 172, 200, 0.1);
        }
    </style>

</head>
<body>
<div class="col-xs-12 no-padding text-center" id="page-content">

    <h3>{{ env('APP_NAME') }} Partner Program Terms and Conditions</h3>

    <div class="col-md-12 text-left most">
        <p><u>Most Important</u></p>
        <div>
            Affiliate Program is initially made valid for 2 years from the date of joining.
            If we think the promotion is continuing to be profitable, we will happily extend
            the time period.
        </div>
    </div>

    <h4>1. Terms</h4>

    <p>By accessing this Website, accessible from {{ $_SERVER['REMOTE_ADDR'] }}, you are agreeing to be bound by these Website Terms and Conditions of Use and agree that you are responsible for the agreement with any applicable local laws. If you disagree with any of these terms, you are prohibited from accessing this site. The materials contained in this Website are protected by copyright and trade mark law.</p>

    <h4>2. Use License</h4>

    <p>Permission is granted to temporarily download one copy of the materials on {{ env('APP_NAME') }}'s Website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>

    <ul style="text-align: left">
        <li>modify or copy the materials;</li>
        <li>use the materials for any commercial purpose or for any public display;</li>
        <li>attempt to reverse engineer any software contained on {{ env('APP_NAME') }}'s Website;</li>
        <li>remove any copyright or other proprietary notations from the materials; or</li>
        <li>transferring the materials to another person or "mirror" the materials on any other server.</li>
    </ul>

    <p>This will let {{ env('APP_NAME') }} to terminate upon violations of any of these restrictions. Upon termination, your viewing right will also be terminated and you should destroy any downloaded materials in your possession whether it is printed or electronic format. These Terms of Service has been created with the help of the <a href="https://www.termsofservicegenerator.net">Terms Of Service Generator</a>.</p>

    <h4>3. Disclaimer</h4>

    <p>All the materials on {{ env('APP_NAME') }}’s Website are provided "as is". {{ env('APP_NAME') }} makes no warranties, may it be expressed or implied, therefore negates all other warranties. Furthermore, {{ env('APP_NAME') }} does not make any representations concerning the accuracy or reliability of the use of the materials on its Website or otherwise relating to such materials or any sites linked to this Website.</p>

    <h4>4. Limitations</h4>

    <p>{{ env('APP_NAME') }} or its suppliers will not be hold accountable for any damages that will arise with the use or inability to use the materials on {{ env('APP_NAME') }}’s Website, even if {{ env('APP_NAME') }} or an authorize representative of this Website has been notified, orally or written, of the possibility of such damage. Some jurisdiction does not allow limitations on implied warranties or limitations of liability for incidental damages, these limitations may not apply to you.</p>

    <h4>5. Revisions and Errata</h4>

    <p>The materials appearing on {{ env('APP_NAME') }}’s Website may include technical, typographical, or photographic errors. {{ env('APP_NAME') }} will not promise that any of the materials in this Website are accurate, complete, or current. {{ env('APP_NAME') }} may change the materials contained on its Website at any time without notice. {{ env('APP_NAME') }} does not make any commitment to update the materials.</p>

    <h4>6. Links</h4>

    <p>{{ env('APP_NAME') }} has not reviewed all of the sites linked to its Website and is not responsible for the contents of any such linked site. The presence of any link does not imply endorsement by {{ env('APP_NAME') }} of the site. The use of any linked website is at the user’s own risk.</p>

    <h4>7. Site Terms of Use Modifications</h4>

    <p>{{ env('APP_NAME') }} may revise these Terms of Use for its Website at any time without prior notice. By using this Website, you are agreeing to be bound by the current version of these Terms and Conditions of Use.</p>

    <h4>8. Your Privacy</h4>

    <p>Please read our Privacy Policy.</p>

    <h4>9. Governing Law</h4>

    <p>Any claim related to {{ env('APP_NAME') }}'s Website shall be governed by the laws of bd without regards to its conflict of law provisions.</p>

</div>


</body>
</html>