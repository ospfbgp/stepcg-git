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
    <span>ERS Fabric Attach Startup: v1.0</span>
    <hr>
</header>
<?php
$sntpserver = "1.1.1.1";
$syslog = "1.1.1.2";
$timezone = "clock time-zone EST -5 0";
//$timezone = "clock time-zone EST -6 0";
$slpptimeout = "14400";
///https://www.w3schools.com/php/php_form_complete.asp
// define variables and set to empty values
$error = "";
$sysname = "";
$sysnameErr = "";
$contact = "";
$contactErr = "";
$location = "";
$locationErr = "";
$stacksize = "";
$mgmtipaddress = "";
$mgmtipaddressErr = "";
$mgmtnetmask = "";
$defaultgateway = "";
$defaultgatewayErr = "";
$mgmtvlan = "";
$mgmtvlanErr = "";
$mgmtisid = "";
$mgmtisidErr = "";
$faport1 = "";
$faport2 = "";

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

  $stacksize = test_input($_POST["stacksize"]);

  if (empty($_POST["mgmtipaddress"])) {
    $mgmtipaddressErr = "Management IP is required";
    $error = 1;
  } else {
    $mgmtipaddress = test_input($_POST["mgmtipaddress"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$mgmtipaddress)) {
      $mgmtipaddressErr = "Only IPv4 Address allowed";
      $error = 1;
    }
  }

  $mgmtnetmask = test_input($_POST["mgmtnetmask"]);

  if (empty($_POST["defaultgateway"])) {
    $defaultgatewayErr = "Default gateway required";
    $error = 1;
  } else {
    $defaultgateway = test_input($_POST["defaultgateway"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$defaultgateway)) {
      $defaultgatewayErr = "Only IPv4 Address allowed";
      $error = 1;
    }
  }

  if (empty($_POST["mgmtvlan"])) {
    $mgmtvlanErr = "Management Vlan required";
    $error = 1;
  } else {
    $mgmtvlan = test_input($_POST["mgmtvlan"]);
  }

  if (empty($_POST["mgmtisid"])) {
    $mgmtisidErr = "Management i-sid required";
    $error = 1;
  } else {
    $mgmtisid = test_input($_POST["mgmtisid"]);
  }

  $faport1 = test_input($_POST["faport1"]);
  $faport2 = test_input($_POST["faport2"]);
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
  Stack Size: 
<select name="stacksize" >
  <option value="1" <?php if($stacksize == '1'){echo("selected");}?>>1</option>
  <option value="2" <?php if($stacksize == '2'){echo("selected");}?>>2</option>
  <option value="3" <?php if($stacksize == '3'){echo("selected");}?>>3</option>
  <option value="4" <?php if($stacksize == '4'){echo("selected");}?>>4</option>
  <option value="5" <?php if($stacksize == '5'){echo("selected");}?>>5</option>
  <option value="6" <?php if($stacksize == '6'){echo("selected");}?>>6</option>
  <option value="7" <?php if($stacksize == '7'){echo("selected");}?>>7</option>
  <option value="8" <?php if($stacksize == '8'){echo("selected");}?>>8</option>
</select>
  <br><br>
  Mgmt IP Address: <input type="text" name="mgmtipaddress" value="<?php echo $mgmtipaddress;?>">
  <span class="error"> <?php echo $mgmtipaddressErr;?></span>
<select name="mgmtnetmask" >
  <option value="255.255.255.0" <?php if($mgmtnetmask == '255.255.255.0'){echo("selected");}?>>255.255.255.0</option>
  <option value="255.255.255.252" <?php if($mgmtnetmask == '255.255.255.252'){echo("selected");}?>>255.255.255.252</option>
  <option value="255.255.255.248" <?php if($mgmtnetmask == '255.255.255.248'){echo("selected");}?>>255.255.255.248</option>
  <option value="255.255.255.240" <?php if($mgmtnetmask == '255.255.255.240'){echo("selected");}?>>255.255.255.240</option>
  <option value="255.255.255.224" <?php if($mgmtnetmask == '255.255.255.224'){echo("selected");}?>>255.255.255.224</option>
  <option value="255.255.255.192" <?php if($mgmtnetmask == '255.255.255.192'){echo("selected");}?>>255.255.255.192</option>
  <option value="255.255.255.128" <?php if($mgmtnetmask == '255.255.255.128'){echo("selected");}?>>255.255.255.128</option>
  <option value="255.255.252.0" <?php if($mgmtnetmask == '255.255.252.0'){echo("selected");}?>>255.255.252.0</option>
  <option value="255.255.248.0" <?php if($mgmtnetmask == '255.255.248.0'){echo("selected");}?>>255.255.248.0</option>
  <option value="255.255.240.0" <?php if($mgmtnetmask == '255.255.240.0'){echo("selected");}?>>255.255.240.0</option>
  <option value="255.255.224.0" <?php if($mgmtnetmask == '255.255.224.0'){echo("selected");}?>>255.255.224.0</option>
  <option value="255.255.192.0" <?php if($mgmtnetmask == '255.255.192.0'){echo("selected");}?>>255.255.192.0</option>
  <option value="255.255.128.0" <?php if($mgmtnetmask == '255.255.128.0'){echo("selected");}?>>255.255.128.0</option>
  <option value="255.255.0.0" <?php if($mgmtnetmask == '255.255.0.0'){echo("selected");}?>>255.255.0.0</option>
</select>
  <br><br>
  Mgmt default gateway: <input type="text" name="defaultgateway" value="<?php echo $defaultgateway;?>">
  <span class="error"> <?php echo $defaultgatewayErr;?></span>
  <br><br>
  Mgmt VLAN: <input type="text" name="mgmtvlan" value="<?php echo $mgmtvlan;?>">
  <span class="error"> <?php echo $mgmtvlanErr;?></span>
  <br><br>
  Mgmt i-sid: <input type="text" name="mgmtisid" value="<?php echo $mgmtisid;?>">
  <span class="error"> <?php echo $mgmtisidErr;?></span>
  <br><br>
  FA Ports: 
<select name="faport1" >
  <option value="1/50" <?php if($faport1 == '1/50'){echo("selected");}?>>1/50</option>
  <option value="1/49" <?php if($faport1 == '1/49'){echo("selected");}?>>1/49</option>
  <option value="1/48" <?php if($faport1 == '1/48'){echo("selected");}?>>1/48</option>
  <option value="1/47" <?php if($faport1 == '1/47'){echo("selected");}?>>1/47</option>
</select>
</select>
<select name="faport2" >
  <option value="" <?php if($faport2 == ''){echo("selected");}?>>none</option>
  <option value="2/50" <?php if($faport2 == '2/50'){echo("selected");}?>>2/50</option>
  <option value="2/49" <?php if($faport2 == '2/49'){echo("selected");}?>>2/49</option>
  <option value="2/48" <?php if($faport2 == '2/48'){echo("selected");}?>>2/48</option>
  <option value="2/47" <?php if($faport2 == '2/47'){echo("selected");}?>>2/47</option>
  <option value="1/50" <?php if($faport2 == '1/50'){echo("selected");}?>>1/50</option>
  <option value="1/49" <?php if($faport2 == '1/49'){echo("selected");}?>>1/49</option>
  <option value="1/48" <?php if($faport2 == '1/48'){echo("selected");}?>>1/48</option>
  <option value="1/47" <?php if($faport2 == '1/47'){echo("selected");}?>>1/47</option>
</select>
  <br><br>
  <input type="submit" name="submit" value="Create Config">  
</form>

<?php
if ($error == 0) {
echo "<hr><span>ERS Fabric Attach Startup Configuration:</span><br><br>";
echo "
<font color=\"blue\">! *** Section 1 ***</font><br>
enable<br>
config t<br>
no password security<br>
no autosave enable<br>
snmp-server name \"<font color=\"orange\">$sysname\"</font><br>
snmp-server contact \"<font color=\"orange\">$contact\"</font><br>
snmp-server location \"<font color=\"orange\">$location\"</font><br>
banner disabled<br>
ssh<br>
terminal width 132<br>
sntp server primary address <font color=\"orange\">$sntpserver</font><br>
sntp enable<br>
clock source sntp<br>
clock summer-time recurring 2 Sunday March 02:00 1 Sunday November 02:00 60<br>
$timezone<br>
logging remote address <font color=\"orange\">$syslog</font><br>
logging remote enable<br>
logging remote level informational<br>
web-server enable<br>
ssl<br>
https-only<br>
<br>
<font color=\"blue\">! *** Section 2 ***</font><br>
vlan configcontrol automatic<br>
vlan create <font color=\"orange\">$mgmtvlan</font> type port <br>
vlan name <font color=\"orange\">$mgmtvlan</font> \"Mgmt\"<br>
vlan mgmt <font color=\"orange\">$mgmtvlan</font><br>
";
}
if ($stacksize > 1){
echo "ip address stack <font color=\"orange\">$mgmtipaddress</font><br>";
} else {
echo "ip address switch <font color=\"orange\">$mgmtipaddress</font><br>";
}
echo "
ip address netmask <font color=\"orange\">$mgmtnetmask</font><br>
ip default-gateway <font color=\"orange\">$defaultgateway</font><br>
i-sid <font color=\"orange\">$mgmtisid</font> vlan <font color=\"orange\">$mgmtvlan</font><br>
qos agent queue-set 4<br>
qos if-group name trusted class trusted<br>
qos if-assign port ALL name trusted<br>
";
if ($stacksize > 1){
echo "stack forced-mode<br>";
}
if (!empty($_POST["faport2"])){
echo "
<br>
<font color=\"blue\">! *** Section 3 ***</font><br>
mlt 1 name \"fa\" enable member <font color=\"orange\">$faport1,$faport2</font><br>
mlt 1 loadbalance advance<br>
mlt shutdown-ports-on-disable enable<br>
interface Ethernet ALL<br>
spanning-tree mstp port <font color=\"orange\">$faport1,$faport2</font> learning disable<br>
exit<br>
vlacp enable<br>
vlacp macaddress 180.c200.f<br>
interface Ethernet ALL<br>
vlacp port <font color=\"orange\">$faport1,$faport2</font> timeout short<br>
vlacp port <font color=\"orange\">$faport1,$faport2</font> timeout-scale 5<br>
vlacp port <font color=\"orange\">$faport1,$faport2</font> enable<br>
exit<br>
interface ethernet <font color=\"orange\">$faport1,$faport2</font><br>
name \"fa: uplink\"<br>
no fa message-authentication<br>
exit<br>
";
} else {
echo "
<br>
<font color=\"blue\">! *** Section 3 ***</font><br>
interface Ethernet ALL<br>
spanning-tree mstp port <font color=\"orange\">$faport1</font> learning disable<br>
exit<br>
vlacp enable<br>
vlacp macaddress 180.c200.f<br>
interface Ethernet ALL<br>
vlacp port <font color=\"orange\">$faport1</font> timeout short<br>
vlacp port <font color=\"orange\">$faport1</font> timeout-scale 5<br>
vlacp port <font color=\"orange\">$faport1</font> enable<br>
exit<br>
interface ethernet <font color=\"orange\">$faport1</font><br>
name \"fa: uplink\"<br>
no fa message authentication<br>
exit<br>
";
}
echo "
<br>
<font color=\"blue\">! *** Section 4 ***</font><br>
fa extended-logging<br>
interface Ethernet ALL<br>
";
$loopCount = stacksize;
for ($x = 1; $x<=$stacksize; $x++) {
echo "slpp-guard port $x/1-48 enable timeout $slpptimeout<br>";
} 
echo "
exit<br>
wri mem<br>
";
?>
</body>
</html>
