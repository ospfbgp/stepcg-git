#!/usr/bin/perl -w
use strict;
use warnings;
use Getopt::Std;
use Time::HiRes;   #support time in milliseconds
use POSIX 'strftime';
my $date = strftime '%Y-%m-%d-%H-%M-%S', localtime;

use vars qw( %options $inputfile $outputfile $community);

# get options -v -H and -C. -H and -C require a value
getopts( 'vi:o:C:', \%options );

&print_usage() if ( ! $options{ i } );
&print_usage() if ( ! $options{ o } );
&print_usage() if ( ! $options{ C } );
$inputfile = $options{ i };
$outputfile = $options{ o };
$community = $options{ C };

# print usage if I do not get options I need
sub print_usage {
    print "Usage:\n\n";
    print "$0 -i <input file> -o <output file> -C snmpcommunity\n";
    exit;
}

# get some time and make it pretty to print on html pages
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst)=localtime(time);
my $timestamp = sprintf ("%02d:%02d:%02d %4d-%02d-%02d",$hour,$min,$sec,$year+1900,$mon+1,$mday);

my $filelocations = "/home/www/devices/core";
my $backups = "/home/backups/avaya/recent";
my $htmlpath = "/devices/core";
my $snmpget = "/usr/bin/snmpget -t5 -OnQt -v 2c"; 
my $snmpwalk = "/usr/bin/snmpwalk -t5 -OnQt -v 2c"; 
my %HoH;
open(FILEHANDLE, "$inputfile") or die("boo! error");
my $ii;
while(<FILEHANDLE>) {
    next if (/^\s+$/);
    next if (/^#/);
    $ii++;
    chomp $_;
    $HoH{$ii}{address} = "$_";
}

#my $serial_file = "/tftpboot/hosts/serial.txt";
#open(FILEHANDLE, "$serial_file") or die("boo! error");
#my @mseriallist;
#while(<FILEHANDLE>) {
#    next if (/^\s+$/);
#    next if (/^#/);
#    chomp $_;
#    push (@mseriallist, $_);
#}
#close FILEHANDLE;


my  %oids = (
        '.1.3.6.1.4.1.2272.30' => 'ers8610',
        '.1.3.6.1.4.1.2272.31' => 'ers8606',
        '.1.3.6.1.4.1.2272.34' => 'ers8603',
        '.1.3.6.1.4.1.2272.43' => 'ers1648',
        '.1.3.6.1.4.1.2272.44' => 'ers1612',
        '.1.3.6.1.4.1.2272.47' => 'ers8310',
        '.1.3.6.1.4.1.2272.58' => 'ers8806',
        '.1.3.6.1.4.1.2272.59' => 'ers8810',
        '.1.3.6.1.4.1.2272.201' => 'vsp9012',
        '.1.3.6.1.4.1.2272.202' => 'vsp4850gts',
        '.1.3.6.1.4.1.2272.203' => 'vsp4850gts-PWR+',
        '.1.3.6.1.4.1.2272.205' => 'vsp8284xsq',
        '.1.3.6.1.4.1.2272.206' => 'vsp4450gsx-PWR+',
        '.1.3.6.1.4.1.2272.208' => 'vsp8404',
        '.1.3.6.1.4.1.2272.209' => 'vsp7254xsq',
        '.1.3.6.1.4.1.2272.210' => 'vsp7254xtq',
        '.1.3.6.1.4.1.45.3.35.1' => 'es450-24T',
        '.1.3.6.1.4.1.45.3.43.1' => 'es420',
        '.1.3.6.1.4.1.45.3.45.1' => 'es380',
        '.1.3.6.1.4.1.45.3.46.1' => 'es470-48t',
        '.1.3.6.1.4.1.45.3.49.1' => 'es460-24t-pwr',
        '.1.3.6.1.4.1.45.3.52.1' => 'ers5510-24t',
        '.1.3.6.1.4.1.45.3.53.1' => 'ers5510-48t',
        '.1.3.6.1.4.1.45.3.57.1' => 'es425-48t',
        '.1.3.6.1.4.1.45.3.57.2' => 'es425-24t',
        '.1.3.6.1.4.1.45.3.59.1' => 'ers5520-24t-pwr',
        '.1.3.6.1.4.1.45.3.59.2' => 'ers5520-48t-pwr',
        '.1.3.6.1.4.1.45.3.61.1' => 'es325-24T',
        '.1.3.6.1.4.1.45.3.65'   => 'ers5530-24tfd',
        '.1.3.6.1.4.1.45.3.71.1' => 'ers4548gt',
        '.1.3.6.1.4.1.45.3.71.2' => 'ers4548gt-pwr',
        '.1.3.6.1.4.1.45.3.71.4' => 'ers4548gt-pwr+',
        '.1.3.6.1.4.1.45.3.71.7' => 'ers4526gtx',
        '.1.3.6.1.4.1.45.3.71.11' => 'ers4524gt-pwr',
        '.1.3.6.1.4.1.45.3.71.8' => 'ers4524gt',
        '.1.3.6.1.4.1.45.3.71.9' => 'ers4526t-pwr',
        '.1.3.6.1.4.1.45.3.72.1' => 'ers2526t',
        '.1.3.6.1.4.1.45.3.72.2' => 'ers2526t-pwr',
        '.1.3.6.1.4.1.45.3.72.3' => 'ers2550t',
        '.1.3.6.1.4.1.45.3.72.4' => 'ers2550t-pwr',
        '.1.3.6.1.4.1.45.3.74.1' => 'ers5698tfd-pwr',
        '.1.3.6.1.4.1.45.3.74.2' => 'ers5698tfd',
        '.1.3.6.1.4.1.45.3.74.3' => 'ers5650td-pwr',
        '.1.3.6.1.4.1.45.3.74.4' => 'ers5650td',
        '.1.3.6.1.4.1.45.3.74.5' => 'ers5632fd',
        '.1.3.6.1.4.1.45.3.77.1' => 'wc8180',
        '.1.3.6.1.4.1.45.3.78.1' => 'ers4826gts-pwr+',
        '.1.3.6.1.4.1.45.3.78.2' => 'ers4850gts-pwr+',
        '.1.3.6.1.4.1.45.3.80.2' => 'ers3526GT-PWR+',
        '.1.3.6.1.4.1.45.3.80.4' => 'ers3524GT-PWR+',
        '.1.3.6.1.4.1.45.3.80.5' => 'ers3510GT',
        '.1.3.6.1.4.1.45.3.80.6' => 'ers3510GT-PWR+',
        '.1.3.6.1.4.1.45.3.79.1' => 'vsp7024xls',
        '.1.3.6.1.4.1.318.1.3.2.7' => 'smartUPS450',
        '.1.3.6.1.4.1.318.1.3.2.10' => 'smartUPS1400',
        '.1.3.6.1.4.1.318.1.3.5.1' => 'symmetraUPS4kVA',
        '.1.3.6.1.4.1.562.70.2.2.1.1' => 'wg7250',
        '.1.3.6.1.4.1.562.73.2.2.2.1' => 'sr3120',
        '.1.3.6.1.4.1.562.73.2.2.3.1' => 'sr1001',
        '.1.3.6.1.4.1.562.73.2.2.3.2' => 'sr1002',
        '.1.3.6.1.4.1.562.73.2.2.3.3' => 'sr1004',
        '.1.3.6.1.4.1.562.73.2.2.5.1.1' => 'sr4134',
        '.1.3.6.1.4.1.562.73.2.2.6.1.1' => 'sr2330',
        '.1.3.6.1.4.1.1872.1.11.2' => 'vpngateway',
        '.1.3.6.1.4.1.1872.1.13.2.1' => 'alteon3408',
        '.1.3.6.1.4.1.1872.1.13.2.3' => 'alteon3408e',
        '.1.3.6.1.4.1.2505.4' => '4500',
        '.1.3.6.1.4.1.2505.7' => '1600',
        '.1.3.6.1.4.1.2505.8' => '2600',
        '.1.3.6.1.4.1.2505.9' => '4600',
        '.1.3.6.1.4.1.2505.1010' => '1010',
        '.1.3.6.1.4.1.2505.1050' => '1050',
        '.1.3.6.1.4.1.2505.1100' => '1100',
        '.1.3.6.1.4.1.2505.1700' => '1700',
        '.1.3.6.1.4.1.2505.1740' => '1740',
        '.1.3.6.1.4.1.2505.1750' => '1750',
        '.1.3.6.1.4.1.2505.2700' => '2700',
        '.1.3.6.1.4.1.2505.5000' => '5000',
    );

my $header = "<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    padding: 6px;
    border-collapse: collapse;
}
</style>
</head>
<body>
";

my $footer ="

</body>
</html>
";
    #border-spacing: 5px;
    #border-collapse: separate;
#th, td {
#    padding: 20;
#}

open(OU,">$outputfile-$date.html");
open(CSV,">$outputfile-$date.csv");
print OU $header;
print OU "Time: $timestamp<br>\n";
print OU "Input File: $inputfile<br>";
print OU "Output File: $outputfile-$date<br>";
print OU "CSV Output File: $outputfile-$date.csv<br>";
print "Input File: $inputfile\n";
print "Output File: $outputfile-$date\n";
print "CSV Output File: $outputfile-$date.csv\n";
print OU "<table border=1>\n";
#foreach my $key  ( sort keys %HoH ) {
#foreach my $key  ( keys %HoH ) {
my $count = 1;
foreach my $key (sort { $a <=> $b} keys %HoH) {
        my @r = (`$snmpget -c $community $HoH{$key}{address} system.sysDescr.0 system.sysObjectID.0 system.sysUpTime.0 system.sysContact.0 system.sysName.0 system.sysLocation.0`);
        if ( !@r ) {  print "Error: $HoH{$key}{address} failed snmp\n"; }
        else {
            foreach (@r){
                  chomp $_;
                  #remove all extra space from string
                  $_ =~ s/\s+/ /g;
                  #remove space from beginning and end of string
                  $_ =~ s/^\s+//;
                  $_ =~ s/\s+$//;
                  #print "$_\n";
                  my @stringa = split ('=',$_,2);
                  #remove space from beginning and end of string
                  $stringa[0] =~ s/^\s+//;
                  $stringa[0] =~ s/\s+$//;
                  #remove space from beginning and end of string
                  $stringa[1] =~ s/^\s+//;
                  $stringa[1] =~ s/\s+$//;
                  #print "stringa1 *$stringa[1]*\n";
                  if ($stringa[1] eq ""){ $stringa[1] = "null"; } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.1.0"){ $HoH{$key}{sysDescr} = &fixsysDescr($stringa[1]); } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.2.0"){
                     $HoH{$key}{oidtoname} = &oidtoname($stringa[1]);
                     $HoH{$key}{sysObjectID} = $stringa[1];

                     # if ers baystack then get serial number
                     my  $ers = '.1.3.6.1.4.1.45.3';
                     if ($stringa[1] =~ m/$ers/) {
                        my @switchserialnum = &ers_serial($HoH{$key}{address});
                        $HoH{$key}{serial} = "";
                        foreach my $s (@switchserialnum) {
                                $HoH{$key}{serial} = "$HoH{$key}{serial} $s ";
                        }
                        $HoH{$key}{stacksize} = &ersstacksize($HoH{$key}{address});
                     }
                     if ( ! defined $HoH{$key}{stacksize} ) {  $HoH{$key}{stacksize} = "n/a"; }

                    # Find vsp switches and get serial numbers
                    my %vsp = (
                      '.1.3.6.1.4.1.2272.202' => 1,
                      '.1.3.6.1.4.1.2272.203' => 1,
                      '.1.3.6.1.4.1.2272.205' => 2,
                      '.1.3.6.1.4.1.2272.206' => 3,
                      '.1.3.6.1.4.1.2272.208' => 4,
                      '.1.3.6.1.4.1.2272.210' => 5
                    );
                    for my $myoid ( keys %vsp ) {
                           if ( $stringa[1] =~ m/$myoid/ ) {
                              $HoH{$key}{serial} = &voss_serial($HoH{$key}{address});
                           }
                    }
                   
                  } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.3.0"){
                     #$HoH{$key}{sysUpTime} = $stringa[1];
                     my $ticks   = shift;
                     my $TICKS_PER_SECOND = 100;
                     my $TICKS_PER_MINUTE = $TICKS_PER_SECOND * 60;
                     my $TICKS_PER_HOUR   = $TICKS_PER_MINUTE * 60;
                     my $TICKS_PER_DAY    = $TICKS_PER_HOUR * 24;
                     my $seconds = int($stringa[1] / $TICKS_PER_SECOND) % 60;
                     my $minutes = int($stringa[1] / $TICKS_PER_MINUTE) % 60;
                     my $hours   = int($stringa[1] / $TICKS_PER_HOUR)   % 24;
                     my $days    = int($stringa[1] / $TICKS_PER_DAY);
                     $HoH{$key}{sysUpTime} = sprintf ("%03d:%02d:%02d:%02d",$days,$hours,$hours,$minutes,$seconds);
                  } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.4.0"){ $HoH{$key}{sysContact} = $stringa[1]; } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.5.0"){ $HoH{$key}{sysName} = $stringa[1]; } 
                  if ($stringa[0] eq ".1.3.6.1.2.1.1.6.0"){ $HoH{$key}{sysLocation} = $stringa[1]; }

            }
            print CSV "$key,$HoH{$key}{address},$HoH{$key}{sysName},$HoH{$key}{sysLocation},$HoH{$key}{oidtoname},$HoH{$key}{sysDescr},$HoH{$key}{sysUpTime},$HoH{$key}{stacksize},";
            if ( defined $HoH{$key}{serial} ) {  print CSV "$HoH{$key}{serial}\n"; } else { print CSV "n/a\n"; }
            print OU "  <tr>\n";
            #print "count $count\n";
            #print OU"     <td>$key</td>\n";
            print OU"     <td>$count</td>\n";
            print OU"     <td>$HoH{$key}{address}</td>\n";
            print OU "    <td nowrap >$HoH{$key}{sysName}</td>\n";
            print OU "    <td>$HoH{$key}{sysLocation}</td>\n";
            #print OU "    <td>$HoH{$key}{oidtoname}</td>\n";
            print OU "    <td>$HoH{$key}{sysDescr}</td>\n";
            print OU "    <td>$HoH{$key}{sysUpTime}</td>\n";
            print OU "    <td>$HoH{$key}{stacksize}</td>\n";
            print OU "   <td>";
            if ( defined $HoH{$key}{serial} ) {  print OU "$HoH{$key}{serial}";   } else { print OU "n/a"; }
            print OU "  </td>\n";
            print OU " </tr>\n";
            $count++;
          }
}      
print OU "</table>\n";
print OU $footer;
close OU;
close CSV;
exit;

sub fixsysDescr { 
       my $sysDescr = $_[0];
       $sysDescr =~ s/AVAYA Secure Router 2330 SNMP Agent, Software/SR/;
       $sysDescr =~ s/Ethernet Routing Switch/ERS/;
       $sysDescr =~ s/Ethernet Switch/ES/;
       $sysDescr =~ s/Virtual Services Platform/VSP/;
       $sysDescr =~ s/Wireless LAN Controller//;
       $sysDescr =~ s/\(c\) Nortel Networks//;
       return $sysDescr;
}

sub oidtoname { 
      # $sysDescr =~ s/AVAYA Secure Router 2330 SNMP Agent, Software/SR/;
      # $sysDescr =~ s/Ethernet Routing Switch/ERS/;
      # $sysDescr =~ s/Ethernet Switch/ES/;
      # $sysDescr =~ s/Virtual Services Platform/VSP/;
      # $sysDescr =~ s/Wireless LAN Controller//;
      # $sysDescr =~ s/\(c\) Nortel Networks//;
       my $sysObjectID = $_[0];
       if (defined $oids{$sysObjectID}){
#             print "oid match $sysObjectID\n";
             return $oids{$sysObjectID};
       } else { 
         print "no oid match $sysObjectID\n";
         return $sysObjectID; 
       }

}

sub ers_serial {
      my $ipaddress = $_[0];
      my @getserial7  = (`$snmpwalk -c $community $ipaddress .1.3.6.1.4.1.45.1.6.3.3.1.1.7.3`);
      my @serials;
      foreach (@getserial7) {
                chomp $_;
                $_ =~ s/^\s+//; #remove leading spaces
                $_ =~ s/\s+$//; #remove trailing spaces
                my @a = split (/=/,$_);
                if (defined $a[0]){ $a[0] =~ s/^\s+//;} #remove leading spaces
                if (defined $a[0]){ $a[0] =~ s/\s+$//;} #remove trailing spaces
                if (defined $a[1]){ $a[1] =~ s/^\s+//;} #remove leading spaces
                if (defined $a[1]){ $a[1] =~ s/\s+$//;} #remove trailing spaces
                if ($a[1] ne "\"\"") {
                   $a[1] =~ s/"//g; #remove double quotes
                   push (@serials, $a[1]);
                }
      }
      return @serials; 
}

sub voss_serial {
      my $ipaddress = $_[0];
      $_  = (`$snmpget -c $community $ipaddress .1.3.6.1.4.1.2272.1.4.2.0`);
      chomp $_;
      $_ =~ s/^\s+//; #remove leading spaces
      $_ =~ s/\s+$//; #remove trailing spaces
      my @a = split (/=/,$_);
      if (defined $a[0]){ $a[0] =~ s/^\s+//;} #remove leading spaces
      if (defined $a[0]){ $a[0] =~ s/\s+$//;} #remove trailing spaces
      if (defined $a[1]){ $a[1] =~ s/^\s+//;} #remove leading spaces
      if (defined $a[1]){ $a[1] =~ s/\s+$//;} #remove trailing spaces
      if ($a[1] ne "\"\"") { $a[1] =~ s/"//g;} #remove double quotes
      return $a[1]; 
}

sub ersstacksize {
# mib to find stacksize
#snmpwalk -v2c -cdragon 10.239.223.249 .1.3.6.1.4.1.45.1.6.3.3.1.1.2.8 
      my $ipaddress = $_[0];
      my @getserial7  = (`$snmpwalk -c $community $ipaddress .1.3.6.1.4.1.45.1.6.3.3.1.1.7.3`);
      my $serial = "";
      #print @getserial7;
      my $stacksize = 0;
      foreach (@getserial7) {
                chomp $_;
                $_ =~ s/^\s+//; #remove leading spaces
                $_ =~ s/\s+$//; #remove trailing spaces
                my @a = split (/=/,$_);
                if (defined $a[0]){ $a[0] =~ s/^\s+//;} #remove leading spaces
                if (defined $a[0]){ $a[0] =~ s/\s+$//;} #remove trailing spaces
                if (defined $a[1]){ $a[1] =~ s/^\s+//;} #remove leading spaces
                if (defined $a[1]){ $a[1] =~ s/\s+$//;} #remove trailing spaces
                if ($a[1] ne "\"\"") {
                   $a[1] =~ s/"//g; #remove double quotes
                   $stacksize++;
                 #  print "$ipaddress serial *$a[1]*\n";
                   $serial = "$serial $a[1]";
                 #  print "$ipaddress $serial\n";
                }
      }
      #print "stackize = $stacksize\n";
      return $stacksize; 
}
