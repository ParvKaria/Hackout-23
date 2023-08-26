<!DOCTYPE html>
<?php
include('func1.php');
$pid = '';
$ID = '';
$appdate = '';
$apptime = '';
$fname = '';
$lname = '';
$doctor = $_SESSION['dname'];
if (isset($_GET['pid']) && isset($_GET['ID']) && ($_GET['appdate']) && isset($_GET['apptime']) && isset($_GET['fname']) && isset($_GET['lname'])) {
    $pid = $_GET['pid'];
    $ID = $_GET['ID'];
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $appdate = $_GET['appdate'];
    $apptime = $_GET['apptime'];
}

if (isset($_POST['prescribe']) && isset($_POST['pid']) && isset($_POST['ID']) && isset($_POST['appdate']) && isset($_POST['apptime']) && isset($_POST['lname']) && isset($_POST['fname'])) {
    $appdate = $_POST['appdate'];
    $apptime = $_POST['apptime'];
    $disease = $_POST['disease'];
    $allergy = $_POST['allergy'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pid = $_POST['pid'];
    $ID = $_POST['ID'];
    $prescription = $_POST['prescription'];

    $query = mysqli_query($con, "insert into prestb(doctor,pid,ID,fname,lname,appdate,apptime,disease,allergy,prescription) values ('$doctor','$pid','$ID','$fname','$lname','$appdate','$apptime','$disease','$allergy','$prescription')");
    if ($query) {
        echo "<script>alert('Prescribed successfully!');</script>";
    } else {
        echo "<script>alert('Unable to process your request. Try again!');</script>";
    }
}

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <style>
        /* Your custom styles */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Vytal </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="doctor-panel.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Back</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <h3 style="margin-left: 40%; padding-bottom: 20px;">
            Welcome <?php echo $doctor ?>
        </h3>

        <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
            <form class="form-group" name="prescribeform" method="post" action="prescribe.php">

                <!-- Disease textarea -->
                <div class="row">
                    <div class="col-md-4"><label>Disease:</label></div>
                    <div class="col-md-8">
                        <textarea id="disease" cols="86" rows="5" name="disease" required></textarea>
                    </div>
                </div>
                <button id="speakDisease" class="btn btn-primary" type="button">Start Speech Recognition</button>
                <ul id="diseaseResult"></ul>

                <!-- Allergies textarea -->
                <div class="row">
                    <div class="col-md-4"><label>Allergies:</label></div>
                    <div class="col-md-8">
                        <textarea id="allergy" cols="86" rows="5" name="allergy" required></textarea>
                    </div>
                </div>
                <button id="speakAllergy" class="btn btn-primary" type="button">Start Speech Recognition</button>
                <ul id="allergyResult"></ul>

                <!-- Prescription textarea -->
                <div class="row">
                    <div class="col-md-4"><label>Prescription:</label></div>
                    <div class="col-md-8">
                        <textarea id="prescription" cols="86" rows="10" name="prescription" required></textarea>
                    </div>
                </div>
                <button id="speakPrescription" class="btn btn-primary" type="button">Start Speech Recognition</button>
                <ul id="prescriptionResult"></ul>

                <!-- Hidden input fields for other data -->
                <input type="hidden" name="fname" value="<?php echo $fname ?>" />
                <input type="hidden" name="lname" value="<?php echo $lname ?>" />
                <input type="hidden" name="appdate" value="<?php echo $appdate ?>" />
                <input type="hidden" name="apptime" value="<?php echo $apptime ?>" />
                <input type="hidden" name="pid" value="<?php echo $pid ?>" />
                <input type="hidden" name="ID" value="<?php echo $ID ?>" />

                <br><br><br><br>
                <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary"
                       style="margin-left: 40%;">
            </form>
            <br>
        </div>
    </div>

    <!-- Add the JavaScript code below -->
    <script>
        var speakDisease = document.getElementById('speakDisease');
        var speakAllergy = document.getElementById('speakAllergy');
        var speakPrescription = document.getElementById('speakPrescription');
        var diseaseTextarea = document.getElementById('disease');
        var allergyTextarea = document.getElementById('allergy');
        var prescriptionTextarea = document.getElementById('prescription');
        var diseaseResult = document.getElementById('diseaseResult');
        var allergyResult = document.getElementById('allergyResult');
        var prescriptionResult = document.getElementById('prescriptionResult');
        var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        speakDisease.addEventListener('click', function () {
            var recognition = new SpeechRecognition();
            recognition.start();
            recognition.onresult = function (e) {
                var transcript = e.results[0][0].transcript;
                diseaseTextarea.value += transcript + ' , ';
                // var node = document.createElement('li');
                // node.appendChild(document.createTextNode(transcript));
                // diseaseResult.appendChild(node);
            };
        });

        speakAllergy.addEventListener('click', function () {
            var recognition = new SpeechRecognition();
            recognition.start();
            recognition.onresult = function (e) {
                var transcript = e.results[0][0].transcript;
                allergyTextarea.value += transcript + ' , ';
                // var node = document.createElement('li');
                // node.appendChild(document.createTextNode(transcript));
                // allergyResult.appendChild(node);
            };
        });

        speakPrescription.addEventListener('click', function () {
            var recognition = new SpeechRecognition();
            recognition.start();
            recognition.onresult = function (e) {
                var transcript = e.results[0][0].transcript;
                prescriptionTextarea.value += transcript + ' , ';
                // var node = document.createElement('li');
                // node.appendChild(document.createTextNode(transcript));
                // prescriptionTextArea.appendChild(node);
            };
        });
    </script>
</body>
</html>
