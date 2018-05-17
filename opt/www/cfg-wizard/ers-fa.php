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
$stacksize = "";
$sysname = "";
$sysnameErr = "";
$contact = "";
$contactErr = "";
$location = "";
$locationErr = "";
$mgmtipaddress = "";
$mgmtipaddressErr = "";
$mgmtnetmask = "";
$defaultgateway = "";
$defaultgatewayErr = "";
$mgmtvlan = "";
$mgmtvlanErr = "";
$mgmtisid = "";
$mgmtisidErr = "";

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
  Mgmt IP Address: <input type="text" name="mgmtipaddress" value="<?php echo $mgmtipaddress;?>">
  <span class="error"> <?php echo $mgmtipaddressErr;?></span>
<select name="mgmtnetworkmask" >
  <option value="255.255.255.0" <?php if($mgmtnetworkmask == '255.255.255.0'){echo("selected");}?>>255.255.255.0</option>
  <option value="255.255.255.252" <?php if($mgmtnetworkmask == '255.255.255.252'){echo("selected");}?>>255.255.255.252</option>
  <option value="255.255.255.248" <?php if($mgmtnetworkmask == '255.255.255.248'){echo("selected");}?>>255.255.255.248</option>
  <option value="255.255.255.240" <?php if($mgmtnetworkmask == '255.255.255.240'){echo("selected");}?>>255.255.255.240</option>
  <option value="255.255.255.224" <?php if($mgmtnetworkmask == '255.255.255.224'){echo("selected");}?>>255.255.255.224</option>
  <option value="255.255.255.192" <?php if($mgmtnetworkmask == '255.255.255.192'){echo("selected");}?>>255.255.255.192</option>
  <option value="255.255.255.128" <?php if($mgmtnetworkmask == '255.255.255.128'){echo("selected");}?>>255.255.255.128</option>
  <option value="255.255.252.0" <?php if($mgmtnetworkmask == '255.255.252.0'){echo("selected");}?>>255.255.252.0</option>
  <option value="255.255.248.0" <?php if($mgmtnetworkmask == '255.255.248.0'){echo("selected");}?>>255.255.248.0</option>
  <option value="255.255.240.0" <?php if($mgmtnetworkmask == '255.255.240.0'){echo("selected");}?>>255.255.240.0</option>
  <option value="255.255.224.0" <?php if($mgmtnetworkmask == '255.255.224.0'){echo("selected");}?>>255.255.224.0</option>
  <option value="255.255.192.0" <?php if($mgmtnetworkmask == '255.255.192.0'){echo("selected");}?>>255.255.192.0</option>
  <option value="255.255.128.0" <?php if($mgmtnetworkmask == '255.255.128.0'){echo("selected");}?>>255.255.128.0</option>
  <option value="255.255.0.0" <?php if($mgmtnetworkmask == '255.255.0.0'){echo("selected");}?>>255.255.0.0</option>
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
  <input type="submit" name="submit" value="Create Config">  
</form>

<?php
if ($error == 0) {
echo "<hr><span>ERS Fabric Attach Startup Configuration:</span><br><br>";
echo "
enable<br>
config t<br>
$sysname<br>
$sntpserver<br>
$syslog<br>
$timezone<br>
$error<br>
$stacksize<br>
$sysname<br>
$contact<br>
$location<br>
$mgmtipaddress<br>
$mgmtnetmask<br>
$defaultgateway<br>
$mgmtvlan<br>
$mgmtisid<br>
exit<br>
";
}
?>

</body>
</html>
