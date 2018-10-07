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
$mstp = "checked";
$smlt = "";
$vlacp = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mltnum = test_input($_POST["mltnum"]);
    $mltname = test_input($_POST["mltname"]);
    $mltports = test_input($_POST["mltports"]);
    $mltvlans = test_input($_POST["mltvlans"]);
    $vlacp = test_input($_POST["vlacp"]);
    $smlt = test_input($_POST["smlt"]);

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
  MLT Number: <input type="text" name="mltnum" size="3" maxlength="3" value="<?php echo $mltnum;?>">
  <br>
  <br>
  MLT Name: <input type="text" name="mltname" size="20" maxlength="20" value="<?php echo $mltname;?>">
  <br>
  <br>
  MLT Ports: <input type="text" name="mltports" size="35" value="<?php echo $mltports;?>">
  <br>
  <br>
  MLT VLANs: <textarea name="mltvlans" cols="100" rows="6"><?=$mltvlans?></textarea>
  <br>
  <br>
  <input type="checkbox" name="smlt" value="checked" style="zoom:1.5;" <?php echo $smlt;?>>Enable smlt<br>
  <input type="checkbox" name="mstp" value="checked" style="zoom:1.5;"<?php echo $mstp;?>>Disable interface mstp<br>
  <input type="checkbox" name="vlacp" value="checked" style="zoom:1.5;"<?php echo $vlacp;?>>Enable interface vlacp<br>
  <input type="submit" name="submit" value="Create Config">  
  <br>
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
";
if ($vlacp == "checked") {
echo "
vlacp fast-periodic-time 500 timeout short timeout-scale 5 funcmac-addr 01:80:c2:00:00:0f<br>
vlacp enable<br>
";
}
if ($mstp == "checked") {
echo "
no spanning-tree mstp<br>
y<br>
";
}
echo "
exit<br>
<br>
mlt <font color=\"orange\">$mltnum</font> enable<br>
mlt <font color=\"orange\">$mltnum</font> name \"<font color=\"orange\">$mltname</font>\"<br>
mlt <font color=\"orange\">$mltnum</font> member <font color=\"orange\">$mltports</font><br>
mlt <font color=\"orange\">$mltnum</font> encapsulation dot1q<br>
<br>
";
if ($smlt == "checked") {
echo "
interface <font color=\"orange\">$mltnum</font><br>
smlt<br>
exit<br>
<br>
";
}
$vlanarray = preg_split("~\s+~",$mltvlans);
foreach ($vlanarray as $vlan) {
    echo "mlt <font color=\"orange\">$mltnum</font> vlan $vlan<br>";
}
echo "<hr>";

}

?>

</body>
</html>
