<?php

class myTools{

  public static function validateFeed( $sFeedURL )
  {
    $sValidator = 'http://feedvalidator.org/check.cgi?url=';

    if( $sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL)) )
    {
      if( stristr( $sValidationResponse , 'This is a valid RSS feed' ) !== false )
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }


  public static function truncate_text($text, $length = 30, $truncate_string = '...', $truncate_lastspace = false)
  {
    if ($text == '')
    {
      return '';
    }

    if (mb_strlen($text) > $length)
    {
      $truncate_text = self::utf8_substr($text, 0, $length - mb_strlen($truncate_string));
      if ($truncate_lastspace)
      {
        $truncate_text = preg_replace('/\s+?(\S+)?$/', '', $truncate_text);
      }

      return $truncate_text.$truncate_string;
    }
    else
    {
      return $text;
    }
  }



  public static function validateEmail($email){
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
  }

  public static function parseDictionaryFilename($word){
    $out = ereg_replace("[^[:alpha:]]", "_", $word);
    return substr($out, 0 , 20).'.mp3';
  }

  public static function scaleImage(&$width, &$height, $to){

    $hscale = $height / $to;
    $wscale = $width / $to;

    if (($hscale > 1) || ($wscale > 1)) {
      $scale = ($hscale > $wscale)?$hscale:$wscale;
    } else {
      $scale = 1;
    }

    $width = floor($width / $scale);
    $height= floor($height / $scale);

    return array($width, $height, $scale);
  }

  public static function cropThumbnail($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
    $ext = myTools::getFileExtension($image);
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    if ($ext == 'jpg') {
      $source = imagecreatefromjpeg($image);
    }else {
      $source = imagecreatefrompng($image);
    }

    $thumb_image_name = myTools::changeFileExtension($thumb_image_name, $ext, 'jpg');

    imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);

    imagejpeg($newImage,$thumb_image_name, 90);

    chmod($thumb_image_name, 0777);

    return $thumb_image_name;
  }

  public static function getFileName($fileName)
  {
    return substr($fileName, strrpos($fileName,'/')+1,strlen($fileName)-strrpos($fileName,'/'));
  }

  public static function getFileExtension($fileName){
    return strtolower(substr(strrchr($fileName, '.'), 1));
  }

  public static function changeFileExtension($fileName, $old_ext, $new_ext){
    return str_replace(".".$old_ext, ".".$new_ext, $fileName);
  }

  public static function utf8_substr($str,$from,$len){
    # utf8 substr
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
    '$1',$str);
  }
  
  public static  function utf8_ucfirst($string) { 
	return utf8_encode(ucfirst(utf8_decode($string))); 
  }
  
  public static function utf8_strtolower($string) { 
	return utf8_encode(strtolower(utf8_decode($string))); 
  } 

  public static function getCurrentUrl(){
    return (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  }

  public static function mb_strlen($t, $encoding = 'UTF-8')
  {
    /* --enable-mbstring */
    if (function_exists('mb_strlen'))
    {
      return mb_strlen($t, $encoding);
    }
    else
    {
      return strlen(utf8_decode($t));
    }
  }

  public static function resizeImage($body)
  {
    return preg_replace('/<img[^>]+src=(?:\'|")(.+?)(?:\'|")[^>]+(?:\/)?>/i', '<img alt=" " class="autoimgresize" src="\\1" />', $body);
  }

  public static function auto_link_image($text) {
    if (!function_exists("auto_image_tag")) {
      function auto_image_tag($src)
      {
        return $src[1].'<a href="http'.$src[3]."://".$src[4].$src[5].'" target="_blank" rel="nofollow"><img src="http'.$src[3]."://".$src[4].$src[5].'" class="autoimgresize" alt=""/></a>'.$src[6];
      }

    }

    $regex = '/
        (                          # leading text
          <\w+.*?>|                # leading HTML tag, or
          [^=!:\'"\/]|               # leading punctuation, or 
          ^                        # beginning of line
        )
        (
          (?:http(s)?:\/\/)|           # protocol spec, or
          (www\.)                # www.*
        )
        (
          [-\w]+                   # subdomain or domain
          (?:\.[-\w]+)*            # remaining subdomains or domain
          (?::\d+)?                # port
          (?:(?:\/(?:(?:[~\w\+%-]|(?:[,.;:][^\s$]))+)?)+(?i:\.(?:jpg|jpeg|gif|png))) # path
          (?:\?[\w\+%&=.;-]+)?     # query string
          (?:\#[\w\-]*)?           # trailing anchor
        )
        ([[:punct:]]|\s|<|$)       # trailing text
        /x';       

    return preg_replace_callback($regex, "auto_image_tag", $text);

  }

  public static function getSentences($str, $max_word_count = 30)
  {
    $sentences = explode('. ', strip_tags($str));
    $description = "";
    $counter = 0;

    foreach ($sentences as $sentence)
    {
      $words = explode(' ', $sentence);
      $counter += count($words);
      $description .= $sentence . '. ';
      if ($counter > $max_word_count)
      {
        return trim($description);
      }
    }

    return trim($description);
  }

  public static function scrap($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $html = curl_exec($ch);
    if (!$html) {
      $html = null;
    }

    return $html;
  }

  /**
   * strips stopword
   */
  public static function stopwordsToChar($text, $char)
  {
    $words = preg_split('/[^\pL_]/u', $text, -1, PREG_SPLIT_NO_EMPTY);

    $c = new Criteria();
    $c->add(StopwordPeer::NAME, $words, Criteria::IN);
    $c->addSelectColumn(StopwordPeer::NAME);
    $rs = StopwordPeer::doSelectRS($c);
    while ($rs->next()) {
      $word = $rs->getString(1);
      $text = preg_replace("/([^\pL_])({$word})([^\pL_])/ui", "\\1$char\\3", ' '.$text.' ');
      $text = preg_replace("/([^\pL_])({$word})([^\pL_])/ui", "\\1$char\\3", $text); # removes duplicate ones
    }
    return trim($text);
  }  
  
}


?>