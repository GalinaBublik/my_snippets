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



/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function remove_empty_p( $content ) {
  $content = force_balance_tags( $content );
  $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
  $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
  return $content;
}
add_filter('the_content', 'remove_empty_p', 20, 1);

/* remove empty value from array */
  function remove_empty($array) {
        $new = array();
        foreach ($array as $key => $value) {
            if( !empty($value) && $value ){
                $new[$key] = $value;
            }
        }
        return $new;
    }


/* theme mages funtions */
    function get_theme_image($image){
        if( !$image ){
            return;
        }
        return get_template_directory_uri().'/img/'.$image;
    }
    function the_theme_image($image){
        echo get_theme_image($image);
    }

/* SIZE OF FILE  */
  function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }