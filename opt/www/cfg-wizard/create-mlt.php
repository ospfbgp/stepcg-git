<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
span {
    font-weight: bold;
    color: purple;
    font-style: italic;
}
</style>
</head>
<body>  

<header>
    <img src="/images/networkninja.png" height="30px" alt="STEPcg Network Ninja">
    <span>VSP MLT Creator: v1.0</span>
    <hr>
</header>
<?php
$manualarea = "5.2018";
$pribvlan = "4051";
$secbvlan = "4052";
///https://www.w3schools.com/php/php_form_complete.asp
// define variables and set to empty values
$error = "";
$mltnum = "";
$mltname = "";
$mltports = "";
$mltportsErr = "";
$mltvlans = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mltnum = test_input($_POST["mltnum"]);
    $mltname = test_input($_POST["mltname"]);
    $mltports = test_input($_POST["mltports"]);
    $mltvlans = test_input($_POST["mltvlans"]);

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<p>Please input your fields. </span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  MLT Number: <input type="text" name="mltnum" value="<?php echo $mltnum;?>">
  <br>
  <br>
  MLT Name: <input type="text" name="mltname" value="<?php echo $mltname;?>">
  <br>
  <br>
  MLT Ports: <input type="text" name="mltports" value="<?php echo $mltports;?>">
  <br>
  <br>
  MLT VLANs: <textarea name="mltvlans" cols="100" rows="6"><?=$mltvlans?></textarea>
  <br>
  <br>
  <input type="submit" name="submit" value="Create Config">  
</form>
</form>

<?php
if ($error == 0) {
echo "<hr><span>Copy and past your text into VSP:</span><br><br>";
echo "
enable<br>
config t<br>
interface gigabit <font color=\"orange\">$mltports</font><br>
name <font color=\"orange\">\"$mltname\"</font><br>
exit<br>
<br>
mlt <font color=\"orange\">$mltnum</font> enable name \"<font color=\"orange\">$mltname</font>\"<br>
mlt <font color=\"orange\">$mltnum</font> member <font color=\"orange\">$mltports</font><br>
mlt <font color=\"orange\">$mltnum</font> encapsulation dot1q<br>
<br>
";
$vlanarray = preg_split("~\s+~",$mltvlans);
foreach ($vlanarray as $vlan) {
    echo "mlt <font color=\"orange\">$mltnum</font> vlan $vlan<br>";
}
echo "<hr>";

}

?>

</body>
</html>
