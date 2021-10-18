<?php namespace App\Repositories;

use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface
{

    public function updateOrCreate($where, $fields) {

       return Contact::updateOrCreate(
        $where,
        $fields
        );
       
    }

	// more 

}