<?php 
// Script to capture new fingerprint data to enroll

exec("rm ../.tmp/*", $out_clear, $ret_clear);
exec("../bin/enroll", $out_fp, $ret_fp);
exec("convert -brightness-contrast -40x40 ../.tmp/enrolled.pgm ../.tmp/enrolled.jpg",$out_conv,$ret_conv);

$return = $_POST;
$return["output"] = "Clearing old files.\n".implode("\n",$out_clear)."\n\nStarting Scanning.\n".implode("\n",$out_fp)."\n\nStarting Conversion.\n".implode("\n",$out_conv);
$return["return"] = "Clearing old files.\n".implode("\n",$ret_clear)."\n\nStarting Scanning.\n".implode("\n",$ret_fp)."\n\nStarting Conversion.\n".implode("\n",$ret_conv);
$return["result"] = "Finished!";
echo json_encode($return);

?>