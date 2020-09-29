<?php
$zip = new ZipArchive;
$res = $zip->open('ts5.zip');
if ($res === TRUE) {
  $zip->extractTo('../ts5_daniel/');
  $zip->close();
  echo 'woot!';
} else {
  echo 'doh!';
}