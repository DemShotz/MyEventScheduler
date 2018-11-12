<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$conn = "SELECT * FROM events WHERE id='" . $_SESSION['user_id'] . "' AND custom=''";
$result = $mysqli->query($conn);
$jsarray = array();
$finisharray = array();
$jobarray = array();
$jobhoursarray = array();

while ($row = $result->fetch_assoc()) {
     $jsarray[] = $row;
}

$starting = preg_split('/,/', $_POST['starting']);
$ending = preg_split('/,/', $_POST['ending']);

$starting = mktime(0, 0, 0, $starting[0] + 1, $starting[1], $starting[2]);
$ending = mktime(0, 0, 0, $ending[0] + 1, $ending[1], $ending[2]);

if ($starting > $ending) {
     header("Location: ../calculateHours.php?error=1");
     exit;
}

for ($i = 0; $i < sizeof($jsarray); $i++) {
     $monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

     $jsarraydate = preg_split('/\s/', $jsarray[$i]['date']);
     $jsarraydate[0] = array_search($jsarraydate[0], $monthHeader) + 1;

     $jsarraydate = mktime(0, 0, 0, $jsarraydate[0], $jsarraydate[1], $jsarraydate[2]);

     if ($starting <= $jsarraydate && $ending >= $jsarraydate) {
          $finisharray[] = $jsarray[$i];
     }
}

$masterHours = 0;
$masterCounter = 0;
$masterHours = 0;

for ($i = 0; $i < sizeof($finisharray); $i++) {
     $masterCounter = $masterCounter + $finisharray[$i]['eventpay'];

     if (array_key_exists($finisharray[$i]['job'], $jobarray)) {
          $jobarray[$finisharray[$i]['job']] = $jobarray[$finisharray[$i]['job']] + $finisharray[$i]['eventpay'];
     } else {
          $jobarray[$finisharray[$i]['job']] = $finisharray[$i]['eventpay'];
     }

     $start = preg_split("/:/", $finisharray[$i]['timestart']);
     $start[0] = (float)$start[0];
     $start[1] = (float)$start[1];
     $start[1] = $start[1] / 60;
     $start = $start[0] + $start[1];

     $end = preg_split("/:/", $finisharray[$i]['timeend']);
     $end[0] = (float)$end[0];
     $end[1] = (float)$end[1];
     $end[1] = $end[1] / 60;
     $end = $end[0] + $end[1];

     if ($start > $end) {
          $start = abs(24 - $start);
          $counter = $start + $end;
     } else {
          $counter = abs($start - $end);
          $counter = $counter;
     }

     $breaktime = $finisharray[$i]['breaktime'] / 60;

     $counter = $counter - $breaktime;

     $masterHours = $masterHours + $counter;

     if (array_key_exists($finisharray[$i]['job'], $jobhoursarray)) {
          $jobhoursarray[$finisharray[$i]['job']]  =  $jobhoursarray[$finisharray[$i]['job']] + $counter;
     } else {
          $jobhoursarray[$finisharray[$i]['job']] = $counter;
     }
}

?>

<!DOCTYPE HTML>
<html>
<head>
     <meta charset="utf-8">
     <title>Calculate Hours</title>
     <script type="text/JavaScript">
       (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
       (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
       m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
       })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

       ga('create', 'UA-102146882-1', 'auto');
       ga('send', 'pageview');

     </script>
     <link rel="icon" href="../favicon.png" sizes="any" type="image/png">
     <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="calculator">

<div id="header">
     <h1>Calculate Hours</h1>
     <h3 id="date" style="display: none;"></h1>
     <a href="../calculateHours.php">Back</a>
</div>

<script src="../scripts/script.js"></script>

<script>
var perJob = <?php echo json_encode($jobarray) ?>;
var hourJob = <?php echo json_encode($jobhoursarray) ?>;

var masterCounter = <?php echo $masterCounter ?>;
var masterHours = <?php echo $masterHours ?>;

var keyName = Object.keys(perJob);
var hourName = Object.keys(hourJob);

for (i = 0; i < keyName.length; i++) {
     var createParent = document.createElement("div");
     createParent.setAttribute("class", "row6");

     var createChild1 = document.createElement("div");
     var createChild1Text = document.createElement("h4");
     createChild1.setAttribute("class", "coln1");
     createChild1Text.innerHTML = keyName[i];
     createChild1.appendChild(createChild1Text);

     var createChild2 = document.createElement("div");
     var createChild2Text = document.createElement("h4");
     createChild2.setAttribute("class", "coln2");
     createChild2Text.innerHTML = hourJob[hourName[i]].toFixed(2) + " hours";
     createChild2.appendChild(createChild2Text);

     var createChild3 = document.createElement("div");
     var createChild3Text = document.createElement("h4");
     createChild3.setAttribute("class", "coln3");
     createChild3Text.innerHTML = "$" + perJob[keyName[i]];
     createChild3.appendChild(createChild3Text);

     createParent.appendChild(createChild1);
     createParent.appendChild(createChild2);
     createParent.appendChild(createChild3);

     document.getElementsByTagName("body")[0].appendChild(createParent);
}

var createAgain = document.createElement("div");
createAgain.setAttribute("class", "row5 calculator");

var createAnother1 = document.createElement("div");
var createAnother1Text = document.createElement("h4");
createAnother1.setAttribute("class", "coln1");
createAnother1Text.innerHTML = "TOTAL:";
createAnother1.appendChild(createAnother1Text);

var createAnother2 = document.createElement("div");
var createAnother2Text = document.createElement("h4");
createAnother2.setAttribute("class", "coln2");
createAnother2Text.innerHTML = masterHours.toFixed(2) + " hours";
createAnother2.appendChild(createAnother2Text);

var createAnother3 = document.createElement("div");
var createAnother3Text = document.createElement("h4");
createAnother3.setAttribute("class", "coln3");
createAnother3Text.innerHTML = "$" + masterCounter;
createAnother3.appendChild(createAnother3Text);

createAgain.appendChild(createAnother1);
createAgain.appendChild(createAnother2);
createAgain.appendChild(createAnother3);

document.getElementsByTagName("body")[0].appendChild(createAgain);

</script>

</body>
</html>
