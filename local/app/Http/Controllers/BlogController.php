<?php

namespace Responsive\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Responsive\Http\Requests;
use Responsive\User;

use Mail;
use Auth;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
	public function BlogIndex() {
		
          $url = 'http://blog.guarddme.com/wp-json/wp/v2/posts';
          $response =  $this->curl($url);
               
            $posts = json_decode($response,true);
          
          
        
        
          $new_posts = array();
          $count = 0;
          foreach($posts as $post)
          {
            $new_post[$count]['title'] = $post['title']['rendered'];
            $new_post[$count]['content'] = $this->custom_echo($post['content']['rendered'], 300);
            $new_post[$count]['date'] = $post['date'];
            $new_post[$count]['link'] = $post['guid']['rendered'];
            
            
                      $url2 = $post['_links']['wp:featuredmedia']['0']['href'];
                      $respons2 =  $this->curl($url2);
                      $image = json_decode($respons2,true);
                    
             $new_post[$count]['image'] = $image['guid']['rendered'];
                $count++; 
           }
          
          return view('blog',['posts'=>$new_post]);
		
   }
   
   private function curl($url){
    
        $ch2 = curl_init();
                    curl_setopt($ch2, CURLOPT_URL, $url);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3");
                    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
                    $respons2 = curl_exec($ch2); 
                    curl_close($ch2); 
                    return $respons2;
                   
   }
   
    private function custom_echo($x, $length)
    {
      if(strlen($x)<=$length)
      {
        return $x;
      }
      else
      {
        $y=substr($x,0,$length) . '...';
        return $y;
      }
    }
   
  
}
