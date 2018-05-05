<?php

namespace App\Repositories;


interface RssRepositoryContract {
    public function query();
	
	public function update($ids);
}