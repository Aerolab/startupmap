<?php
/** 
 * @package StartupsMap
 * @version 0.1
 */

if (App::environment('production')) {
    App::error(function($exception, $code){
        switch ($code)
        {
            case 403:
                return Response::view('error', array('error' => '403'), 403);

            case 404:
                return Response::view('error', array('error' => '404'), 404);

            case 500:
                return Response::view('error', array('error' => '500'), 500);

            default:
                return Response::view('error', array('error' => '404'), $code);
        }
    });
}