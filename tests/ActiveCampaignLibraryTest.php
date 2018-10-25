<?php

require_once 'src/ActiveCampaignLibrary.php';

use PHPUnit\Framework\TestCase;

final class ActiveCampaignLibraryTest extends TestCase{

    public function setUp() {
        $this->ActiveCampaignLibrary = new ActiveCampaignLibrary.php('apiurl', 'apikey'); 
    }

    public function tearDown() {
		  unset($this->ActiveCampaignLibrary);
    }
   
  
   

}


