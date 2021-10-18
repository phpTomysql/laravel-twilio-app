<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use App\Services\ContactService;

class CallResponderController extends Controller
{
    private $service;
    
    public function __construct(ContactService $service) {
        $this->service = $service; // service
       
    }

    public function index(Request $request) {
       
       
         $response = new VoiceResponse();
         $response->say('Welcome. Please provide answers of some questions.');
         
         try {

        
           $this->service->recordCall($request); // save initial values

           $gather = $response->gather(['numDigits' => 1, 'action' => secure_url('twilio/webhook/q1')]);
           $gather->say(\Config::get('survey.q1.question')); // question 1
           $gather->say(\Config::get('survey.q1.options')); // options
           $response->say(\Config::get('survey.noInput')); // if no input
           $response->redirect(secure_url('twilio/webhook')); // re try
           return $response;

         

         }
         catch(\Exception $e){
        
            \Log::info('error message: '.$e->getMessage()); // log error
            $response->say('Hey, we will call you back soon.');
            return $response;
         }

    }
    public function q1(Request $request) {

        $response = new VoiceResponse();
        $userInput = $request->input('Digits'); // q1 input

        if($userInput >=1 && $userInput<=4) { // valid input

           
        $this->service->recordQuestion($request,['q1'=>$userInput]);

        $gather = $response->gather(['numDigits' => 1, 'action' => secure_url('twilio/webhook/q2')]);
        
        $gather->say(\Config::get('survey.q2.question')); // q2
        $gather->say(\Config::get('survey.q2.options')); // options 
        
        $response->say(\Config::get('survey.noInput')); // no input

        }else { // invalid input

            $response->say(\Config::get('survey.invalidOption')); 
            $response->redirect(secure_url('twilio/webhook'));
        }
        return $response;
    }

    public function q2(Request $request) {

        $response = new VoiceResponse();
        $userInput = $request->input('Digits'); // q2 input

        if($userInput >=1 && $userInput<=5) { // valid input
            
            $this->service->recordQuestion($request,['q2'=>$userInput]);

            $gather = $response->gather(['action' => secure_url('twilio/webhook/q3'),'finishOnKey'=>'#']);
           
            $gather->say(\Config::get('survey.q3.question'));

            $response->say(\Config::get('survey.noInput'));

        }else { // invalid input

            $response->say(\Config::get('survey.invalidOption'));

            $response->redirect(secure_url('twilio/webhook'));
        }
        return $response;
    }

    public function q3(Request $request) {

        $response = new VoiceResponse();
        $userInput = $request->input('Digits'); // q3 input

        if($userInput !=='') {

            $this->service->recordQuestion($request, ['pincode' => $userInput]);

            $response->say(\Config::get('survey.successMsg'));

            $response->dial('+15005550006');

        }else {

            $response->say(\Config::get('survey.invalidOption'));

            $response->redirect(secure_url('twilio/webhook'));
        }
        return $response;
    }
}
