<?php

/*
Plugin Name: RO Slugs
Plugin URI: http://www.zoso.ro/ro-slugs-plugin/
Description: Converteşte diacriticele în litere latine ca să nu se mai buşească slugurile.
Version: 2.1
Author: Vali Petcu & Friends
*/

add_filter('name_save_pre', 'ro_slugs', 0);
add_action('wp_footer', 'add_url');

function ro_slugs($slug = null) {

    //dacă vreţi să nu vă modifice automat slugul, comentaţi funcţia de mai jos
         if($slug) return $slug;

         $slug = trim(strtolower(stripslashes($_POST['post_title'])));         
         #if(!$slug) return 'super-url-ul-ce-ma-va-duce-pe-locul-1-in-google';
         $map = array(
            '/à|á|å|â|ă|â|Â|Ă|ă/i' => 'a',
            '/è|é|ê|ẽ|ë/i' => 'e',
            '/ì|í|î|î|Î|Î/i' => 'i',
            '/ò|ó|ô|ø/i' => 'o',
            '/ù|ú|ů|û/i' => 'u',
            '/ș|ș|ş|Ș|Ș|Ş/i'=>'s',
            '/ț|ţ|ț|Ț|Ţ/i'=>'t',
            '/&icirc;/i' => 'i',
            '/&acirc;/i' => 'a',
            '/”|“|…|’|µ|º|’|&lsquo;|&rsquo;|ldquo|rdquo|„|»|–/i' => '-',
            '/[^[:alnum:]]/'=>' ',
            '/[^\w\s]/' => ' ',
            '/\\s+/' => '-',
            '/\b([a-z]{1,3})\b/i'=>'',
            '/\-+/' => '-'
        );

  $slug = preg_replace(array_keys($map),array_values($map),$slug);

        $words = array('lui','pentru','daca','inca','dar','sau','imi','iti','isi','prin','din','quot','pic','ale','aproape','aia','asta','cel','mai','lor');
        $slug_array =  array_diff (explode("-", $slug), $words);
        $slug = implode('-',$slug_array);
        return trim($slug,'-');

}

function add_url($options='') {
	echo "\n\n<!--  Blogul foloseşte RO-SLUGS - http://www.zoso.ro/ro-slugs-plugin/  -->\n\n";
}

?>