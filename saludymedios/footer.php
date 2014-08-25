<br>
<br>
<br>
<hr width="70%" size="1">
<div align="center">
<span style="color:#CCCCCC;">
&copy; DIM
</span>
</div>
<?php

/*

$Id: footer.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/


function generateDebugReport($method,$defined_vars,$email="undefined")
{
   // Function to create a debug report to display or email.
   // Usage: generateDebugReport(method,get_defined_vars(),email[optional]);
   // Where method is "browser" or "email".

   echo '<br><br><br><br><br>';
   echo '<hr>';

   // Create an ignore list for keys returned by 'get_defined_vars'.
   // For example, HTTP_POST_VARS, HTTP_GET_VARS and others are
   // redundant (same as _POST, _GET)
   // Also include vars you want ignored for security reasons - i.e. PHPSESSID.
   $ignorelist=array("HTTP_POST_VARS","HTTP_GET_VARS",
   "HTTP_COOKIE_VARS","HTTP_SERVER_VARS",
   "HTTP_ENV_VARS","HTTP_SESSION_VARS",
   "_ENV","PHPSESSID","SESS_DBUSER",
   "SESS_DBPASS","HTTP_COOKIE","_DATE_TIMEZONE_DATA");

   $timestamp=date("m/d/y h:m:s");
   $message="Debug report created $timestamp\n";

   // Get the last SQL error for good measure, where $link is the resource identifier
   // for mysql_connect. Comment out or modify for your database or abstraction setup.
//   global $link;
//   $sql_error=mysql_error($link);
//   if($sql_error){
//     $message.="\nMysql Messages:\n".mysql_error($link);
//   }
   // End MySQL

   // Could use a recursive function here. You get the idea ;-)
   foreach($defined_vars as $key=>$val){
     if(is_array($val) && !in_array($key,$ignorelist) && count($val) > 0){
       $message.="\n$key array (key=value):\n";
       foreach($val as $subkey=>$subval){
         if(!in_array($subkey,$ignorelist) && !is_array($subval)){
           $message.=$subkey." = ".$subval."\n";
         }
         elseif(!in_array($subkey,$ignorelist) && is_array($subval)){
           foreach($subval as $subsubkey=>$subsubval){
             if(!in_array($subsubkey,$ignorelist)){
               $message.=$subsubkey." = ".$subsubval."\n";
             }
           }
         }
       }
     }
     elseif(!is_array($val) && !in_array($key,$ignorelist) && $val){
       $message.="\nVariable ".$key." = ".$val."\n";
     }
   }

   if($method=="browser"){
     echo nl2br($message);
   }
   elseif($method=="email"){
     if($email=="undefined"){
       $email=$_SERVER["SERVER_ADMIN"];
     }

     $mresult=mail($email,"Debug Report for ".$_ENV["HOSTNAME"]."",$message);
     if($mresult==1){
       echo "Debug Report sent successfully.\n";
     }
     else{
       echo "Failed to send Debug Report.\n";     
     }
   }
}
    
if (DEBUG)
{
    generateDebugReport('browser', get_defined_vars());
}

?>
</body>
</html>
