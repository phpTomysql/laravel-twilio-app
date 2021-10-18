<?php
namespace App\Services;
use App\Repositories\ContactRepositoryInterface;

class ContactService {

    private $repository;
    
    public function __construct(ContactRepositoryInterface $repository) {
        $this->repository = $repository;
       
    }

    public function recordCall($request) {

        $From        = $request->input('From'); //+17138934827
        $FromCity    = $request->input('FromCity'); //LEAGUE CITY
        $FromCountry = $request->input('FromCountry'); //US
        $FromState   = $request->input('FromState'); // TX
        $FromZip     = $request->input('FromZip'); // 77040
        $CallSid     = $request->input('CallSid'); 

        $FromAddress = $FromCity. ', '.$FromState.', '.$FromCountry.' '.$FromZip;

        return $this->repository->updateOrCreate(
            ['CallSid' => $CallSid],
            ['pincode' => $FromZip, 'address' => $FromAddress,'phone'=>$From]
        );
    }

    public function recordQuestion($request, $fields) {

       $CallSid     = $request->input('CallSid'); 

       return $this->repository->updateOrCreate(
            ['CallSid' => $CallSid],
            $fields
        );
    }
}