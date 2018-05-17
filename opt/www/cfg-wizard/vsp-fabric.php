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
    <span>VSP Fabric Startup: v1.0</span>
    <hr>
</header>
<?php
$manualarea = "5.2018";
$pribvlan = "4051";
$secbvlan = "4052";
// define variables and set to empty values
$error = "";
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
$vistvlan = "";
$vistvlanErr = "";
$vistisid = "";
$vistvlanisidErr = "";
$vistipaddress = "";
$vistipaddressErr = "";
$vistnetworkmask = "";
$vistnetworkmaskErr = "";
$vistpeerip = "";
$vistpeeripErr = "";
$smltpeersystemid = "";
$smltpeersystemidErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["sysname"])) {
    $sysnameErr = "Sys-name is required";
    $error = 1;
  } else {
    $sysname = test_input($_POST["sysname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-z0-9.\-]+$/i",$sysname)) {
      $sysnameErr = "Only letters, numbers, . and -";
      $error = 1;
    }
  }

  if (empty($_POST["contact"])) {
    $contactErr = "SNMP Contact is required";
    $error = 1;
  } else {
    $contact = test_input($_POST["contact"]);
  }

  if (empty($_POST["location"])) {
    $locationErr = "SNMP Location is required";
    $error = 1;
  } else {
    $location = test_input($_POST["location"]);
  }

  if (empty($_POST["loopback1"])) {
    $loopback1Err = "Loopback 1 is required";
    $error = 1;
  } else {
    $loopback1 = test_input($_POST["loopback1"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/ 
",$loopback1)) {
      $loopback1Err = "Only IPv4 Address allowed";
      $error = 1;
    }
  }

  if (empty($_POST["nickname"])) {
    $nicknameErr = "Nick-name is required";
    $error = 1;
  } else {
    $nickname = test_input($_POST["nickname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-fA-F0-9]{1}\.[a-fA-F0-9]{1,2}\.[a-fA-F0-9]{1,2}$/ ",$nickname)) {
      $nicknameErr = "Nickname x.xx.xx in hex";
      $error = 1;
    }
  }

  if (empty($_POST["isisinterfaces"])) {
    $isisinterfacesErr = "ISIS Interfaces required";
    $error = 1;
  } else {
    $isisinterfaces = test_input($_POST["isisinterfaces"]);
  }

  if (!empty($_POST["vistvlan"])) {
    $vistvlan = test_input($_POST["vistvlan"]);
    $vistisid = test_input($_POST["vistisid"]);
    $vistipaddress = test_input($_POST["vistipaddress"]);
    $vistnetworkmask = test_input($_POST["vistnetworkmask"]);
    $vistpeerip = test_input($_POST["vistpeerip"]);
    $smltpeersystemid = test_input($_POST["smltpeersystemid"]);
  } 

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<p>Please input your fields. <span class="error">* required field</span></p>
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
  <br>
  <br>
  <span>Virtual-Ist setup for clustered VSP switches</span>
  <hr>
  Vist VLAN: <input type="text" name="vistvlan" value="<?php echo $vistvlan;?>">
  <span class="error"> <?php echo $vistvlanErr;?></span>
  <br><br>
  Vist i-sid: <input type="text" name="vistisid" value="<?php echo $vistisid;?>">
  <span class="error"> <?php echo $vistisidErr;?></span>
  <br><br>
  Vist IP Address: <input type="text" name="vistipaddress" value="<?php echo $vistipaddress;?>">
  <span class="error"> <?php echo $vistipaddressErr;?></span>
<select name="vistnetworkmask" >
  <option value="255.255.255.252" <?php if($vistnetworkmask == '255.255.255.252'){echo("selected");}?>>255.255.255.252</option>
  <option value="255.255.255.248" <?php if($vistnetworkmask == '255.255.255.248'){echo("selected");}?>>255.255.255.248</option>
  <option value="255.255.255.240" <?php if($vistnetworkmask == '255.255.255.240'){echo("selected");}?>>255.255.255.240</option>
  <option value="255.255.255.224" <?php if($vistnetworkmask == '255.255.255.224'){echo("selected");}?>>255.255.255.224</option>
  <option value="255.255.255.192" <?php if($vistnetworkmask == '255.255.255.192'){echo("selected");}?>>255.255.255.192</option>
  <option value="255.255.255.128" <?php if($vistnetworkmask == '255.255.255.128'){echo("selected");}?>>255.255.255.128</option>
  <option value="255.255.255.0" <?php if($vistnetworkmask == '255.255.255.0'){echo("selected");}?>>255.255.255.0</option>
  <option value="255.255.254.0" <?php if($vistnetworkmask == '255.255.254.0'){echo("selected");}?>>255.255.254.0</option>
</select>
  <br><br>
  Vist Peer IP Address: <input type="text" name="vistpeerip" value="<?php echo $vistpeerip;?>">
  <span class="error"> <?php echo $vistpeeripErr;?></span>
  <br><br>
  SMLT Peer system-id: <input type="text" name="smltpeersystemid" value="<?php echo $smltpeersystemid;?>">
  <span class="error"> <?php echo $smltpeersystemidErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Create Config">  
</form>

<?php
if ($error == 0) {
echo "<hr><span>VSP Fabric Startup Configuration:</span><br><br>";
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
<hr>
";

if (!empty($_POST["vistvlan"])){
echo "<span>VSP Vist Configuration:</span><br><br>";
echo "
enable<br>
config t<br>
vlan create <font color=\"orange\">$vistvlan</font> name \"vist\" type port-mstprstp 1<br>
vlan i-sid <font color=\"orange\">$vistvlan $vistisid</font><br>
interface Vlan <font color=\"orange\">$vistvlan</font><br>
ip address <font color=\"orange\">$vistipaddress $vistnetworkmask</font><br>
exit<br>
<br>
no router isis enable<br>
y<br>
<br>
virtual-ist peer-ip <font color=\"orange\">$vistpeeripaddress</font> vlan <font color=\"orange\">$vistvlan</font><br>
router isis<br>
spbm 1 smlt-peer-system-id <font color=\"orange\">$smltpeersystemid</font><br>
router isis enable<br>
<br>
ip rsmlt edge-support<br>
exit<br>
<hr>
";

}

}
?>
</body>
</html>
