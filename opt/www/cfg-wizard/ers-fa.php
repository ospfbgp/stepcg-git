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
$timezone = "EST";
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
  Location: <input type="text" name="location" value="<?php echo $location;?>">
  <span class="error">* <?php echo $locationErr;?></span>
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
</select>
<select name="faport2" >
  <option value="" <?php if($faport2 == ''){echo("selected");}?>>none</option>
  <option value="2/50" <?php if($faport2 == '2/50'){echo("selected");}?>>2/50</option>
  <option value="2/49" <?php if($faport2 == '2/49'){echo("selected");}?>>2/49</option>
</select>
  <br><br>
  <input type="submit" name="submit" value="Create Config">  
</form>

<?php
if ($error == 0) {
echo "<hr><span>ERS Fabric Attach Startup Configuration:</span><br><br>";
echo "
enable<br>
config t<br>
sysname=$sysname<br>
sntpserver=$sntpserver<br>
syslog=$syslog<br>
timezone=$timezone<br>
stacksize=$stacksize<br>
sysname=$sysname<br>
contact=$contact<br>
location=$location<br>
mgmtipaddress=$mgmtipaddress<br>
mgmtnetmask=$mgmtnetmask<br>
defaultgateway=$defaultgateway<br>
mgmtvlan=$mgmtvlan<br>
mgmtisid=$mgmtisid<br>
exit<br>
";
}
if (!empty($_POST["faport2"])){
echo "
<span>MLT</span><br>
faport1=$faport1<br>
faport2=$faport2<br>
";
} else {
echo "
<span>NO MLT</span><br>
faport1=$faport1<br>
faport2=$faport2<br>
";
}
?>

</body>
</html>
