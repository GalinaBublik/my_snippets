<?php 
/*------------------------------------Выборка тегов html с текста ------------------------*/
/*------------------------------------Delete tags html from text ------------------------*/
if(preg_match('/<\/?\w+((\s\w+=".+")+)?>/', $text)){
    $text = preg_replace ('/<\/?\w+((\s\w+=".+")+)?>/', '', $text);
}

/*------------------------------------ Проверка на аякс-запрос ------------------------*/
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH']) ){ // no ajax
	get_header(); 

}
/*------------------------------------ security file_get_contents ------------------------*/

function curl_get_contents($url)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}


  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //print result
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, 1); //write logs
   $info = curl_getinfo($ch); //info for debug 
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;




