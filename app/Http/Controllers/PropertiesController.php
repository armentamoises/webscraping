<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

use Symfony\Component\HttpClient\HttpClient;

class PropertiesController extends Controller
{
    
    /**
    * Method to obtain images of the passed property
    *
    * @return array
    */
    public function getPropertyImages($propertyID, Client $client)
    {
        $crawler = $client->request('GET', 'https://www.airbnb.mx/rooms/'.$propertyID);
        

        $images = $crawler->filter('picture')->each(function ($node, $i){
            return $node->html();

        });

        
        $images_list = array();

        foreach ($images as $key => $value) {
            $elements = explode('src="', $value);
            if(isset($elements[1])){
                $new_image = explode(' ', $elements[1]); 
                $images_list[] = $new_image[0];   
            }
        }
        
        // dd( $images_list);

        if(count($images_list)> 0){
            return response()->json([
                'success'   => true,
                'message'   => 'Data fetched successfully.',
                'data'      => $images_list
            ], 200);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => 'There are no available images for the requested Airbnb property.',
                'data'      => []
            ], 403);
        }


        /*

        // Button to display more images of the property
        $crawler = $client->request('GET', 'https://www.airbnb.mx/rooms/'.$propertyID);
            
        $buttons = $crawler->filter("div > ._5ltqju")->each(function ($node, $i){
            return $node->html();
        });

        dd( $buttons);

        //This is the value for buttons[0]
        // "<div class="_13sj9hk">
        // <div class="_100fji8"><div class="c1d4ry4s dir dir-ltr">
        // <button aria-label="Imagen del alojamiento 1, Mostrar todas las fotos" type="button" class="_1xh26pm2 l1ovpqvx dir dir-ltr">
        // <div class="dqra4ro bmwtyu7 dir dir-ltr" style="--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url('data:image/png;base64,null');--dls-liteimage-background-size:cover">
        // <picture class=" dir dir-ltr">
        // <source srcset="https://a0.muscache.com/im/pictures/miso/Hosting-715825575916402712/original/4e9a0cac-e867-4b9e-a667-4abced3e95b9.jpeg?im_w=960 1x" media="(max-width: 1439px)"></source><source srcset="https://a0.muscache.com/im/pictures/miso/Hosting-715825575916402712/original/4e9a0cac-e867-4b9e-a667-4abced3e95b9.jpeg?im_w=1200 1x" media="(min-width: 1439.1px)"></source><img class="itu7ddv i1mla2as i1cqnm0r dir dir-ltr" style="--dls-liteimage-object-fit:cover" aria-hidden="true" alt="" elementtiming="LCP-target" fetchpriority="high" id="FMP-target" src="https://a0.muscache.com/im/pictures/miso/Hosting-715825575916402712/original/4e9a0cac-e867-4b9e-a667-4abced3e95b9.jpeg?im_w=720" data-original-uri="https://a0.muscache.com/im/pictures/miso/Hosting-715825575916402712/original/4e9a0cac-e867-4b9e-a667-4abced3e95b9.jpeg"></picture><div class="rsb5yse bmwtyu7 dqqltwe dir dir-ltr" style="--dls-liteimage-background-size:cover;--dls-liteimage-background-image:url(https://a0.muscache.com/im/pictures/miso/Hosting-715825575916402712/original/4e9a0cac-e867-4b9e-a667-4abced3e95b9.jpeg?im_w=720)"></div></div></button></div></div></div> ◀

        // Click to button element
        $link = $crawler->selectLink($buttons[0])->link();
        $content = $client->click($link)->text();
        $links = explode('"picture":', $content);
        
        // dd( $content);

        */
        
    }
    
}
