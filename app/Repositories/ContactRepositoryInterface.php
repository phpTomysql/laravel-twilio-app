<?php namespace App\Repositories;

interface ContactRepositoryInterface{
	
	
    public function updateOrCreate($where, $fields);
	// more
}