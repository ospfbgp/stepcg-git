<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
///https://www.w3schools.com/php/php_form_complete.asp
// define variables and set to empty values
$sysname = "";
$sysnameErr = "";
$contact = "";
$contactErr = "";
$location = "";
$locationErr = "";
$loopback1 = "";
$loopback1Err = "";
$nickname = "";
$nicknameErr = "";
$isisinterfaces = "";
$isisinterfacesErr = "";
$manualarea = "5.2018";
$pribvlan = "4051";
$secbvlan = "4052";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["sysname"])) {
    $sysnameErr = "Sys-name is required";
  } else {
    $sysname = test_input($_POST["sysname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-z0-9.\-]+$/i",$sysname)) {
      $sysnameErr = "Only letters, numbers, . and -"; 
    }
  }

  if (empty($_POST["contact"])) {
    $contactErr = "SNMP Contact is required";
  } else {
    $contact = test_input($_POST["contact"]);
  }

  if (empty($_POST["location"])) {
    $locationErr = "SNMP Location is required";
  } else {
    $location = test_input($_POST["location"]);
  }

  if (empty($_POST["loopback1"])) {
    $loopback1Err = "Loopback 1 is required";
  } else {
    $loopback1 = test_input($_POST["loopback1"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/ 
",$loopback1)) {
      $loopback1Err = "Only IPv4 Address allowed"; 
    }
  }

  if (empty($_POST["nickname"])) {
    $nicknameErr = "Nick-name is required";
  } else {
    $nickname = test_input($_POST["nickname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-fA-F0-9]{1}\.[a-fA-F0-9]{1,2}\.[a-fA-F0-9]{1,2}$/ ",$nickname)) {
      $nicknameErr = "Nickname x.xx.xx in hex"; 
    }
  }

  if (empty($_POST["isisinterfaces"])) {
    $isisinterfacesErr = "ISIS Interfaces required";
  } else {
    $isisinterfaces = test_input($_POST["isisinterfaces"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>VSP Fabric Startup</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Sys name: <input type="text" name="sysname" value="<?php echo $sysname;?>">
  <span class="error">* <?php echo $sysnameErr;?></span>
  <br><br>
  Contact: <input type="text" name="contact" value="<?php echo $contact;?>">
  <span class="error">* <?php echo $contactErr;?></span>
  <br><br>
  Location: <input type="text" name="location" value="<?php echo $location;?>">
  <span class="error">* <?php echo $locationErr;?></span>
  <br><br>
  SPBM loopback 1: <input type="text" name="loopback1" value="<?php echo $loopback1;?>">
  <span class="error">* <?php echo $loopback1Err;?></span>
  <br><br>
  SPBM nick-name: <input type="text" name="nickname" value="<?php echo $nickname;?>">
  <span class="error">* <?php echo $nicknameErr;?></span>
  <br><br>
  ISIS interfaces: <input type="text" name="isisinterfaces" value="<?php echo $isisinterfaces;?>">
  <span class="error">* <?php echo $isisinterfacesErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Create Config">  
</form>

<?php
echo "<h2>VSP Fabric Configuration:</h2>";
echo "
enable<br>
config t<br>
ssh<br>
boot config flags ssh<br>
sys name <font color=\"orange\">$sysname</font><br>
spbm<br>
spbm ethertype 0x8100<br>
snmp-server contact \"<font color=\"orange\">$contact</font>\"<br>
snmp-server location \"<font color=\"orange\">$location</font>\"<br>
<br>
router isis<br>
spbm 1<br>
spbm 1 nick-name <font color=\"orange\">$nickname</font><br>
spbm 1 b-vid $pribvlan-$secbvlan primary $pribvlan<br>
spbm 1 ip enable<br>
exit<br>
<br>
interface loopback 1<br>
ip address 1 <font color=\"orange\">$loopback1</font>/255.255.255.255<br>
<br>
vlan create $pribvlan name \"pri-bvlan\" type spbm-bvlan<br>
vlan create $secbvlan name \"sec-bvlan\" type spbm-bvlan<br>
<br>
router isis<br>
ip-source-address <font color=\"orange\">$loopback1</font><br>
manual-area $manualarea<br>
exit<br>
router isis enable<br>
<br>
clock time-zone EST5EDT<br>
ntp<br>
ntp server 169.157.2.243<br>
sys force-topology-ip-flag<br>
sys clipId-topology-ip  1<br>
<br>
vlan members remove 1 <font color=\"orange\">$isisinterfaces</font><br>
interface gigabit <font color=\"orange\">$isisinterfaces</font><br>
name nni<br>
isis<br>
isis spbm 1<br>
isis enable<br>
no shut<br>
vlacp fast-periodic-time 500 timeout short timeout-scale 5 funcmac-addr 01:80:c2:00:00:0f<br>
vlacp enable<br>
no spanning-tree mstp<br>
y<br>
exit<br>
<br>
vlacp enable<br>
";
?>

</body>
</html>
