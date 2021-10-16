<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

class ContactController extends Controller
{
    public function index(Request $request) {
       
       
         $response = new VoiceResponse();
         $response->say('Welcome, please wait a moment.');

         try{
            $From        = $request->input('From'); //+17138934827
            $FromCity    = $request->input('FromCity'); //LEAGUE CITY
            $FromCountry = $request->input('FromCountry'); //US
            $FromState   = $request->input('FromState'); // TX
            $FromZip     = $request->input('FromZip'); // 77040
   
            $FromAddress = $FromCity. ', '.$FromState.', '.$FromCountry.' '.$FromZip;
   
            $contactSaved = \App\Models\Contact::updateOrCreate(
                ['phone' => $From],
                ['pincode' => $FromZip, 'address' => $FromAddress]
            );
            
            $response->dial('+15005550006'); //pass in phone number to dial
            return $response;
         }
         catch(\Exception $e){
            // do task when error
            // echo $e->getMessage();   // insert query
            $response->say('Hey, we will call you back soon.');
            return $response;
         }

    }
}
