<?php 
     define('_SAPE_USER', 'ae07df4afafcbc7b10de16aaf234380f');
     require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'); 
     $sape_articles = new SAPE_articles();
     echo $sape_articles->process_request();
?>
