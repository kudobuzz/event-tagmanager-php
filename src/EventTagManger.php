<?php 
require_once("src/require.php");
class EventTagManger {


    private $activecampaign;
    private $platform;
    private $app;

    public function __construct ($data) {
        foreach(get_object_vars($this) as $key=>$value ){
			if( array_key_exists($key, $data) ){
				$this->{$key} = $data[$key];
			}
        }

        $this->activecampaign = new ActiveCampaignLib();
    }


    //add contact to activecampaign
    public function addContact($contactDetails) {

        $requiredDetails = [
            'email',
            'first_name',
            'last_name',
            'list_id'
        ];

        $contactDetails['list_id'] = LIST_ID;

        $this->activecampaign->addNewContact($requiredDetails, $contactDetails);
    }

    //add tags to contact on activecampaign
    public function addTagsOnInstall($contactTags){

        
        $requiredTags = [
            'email',
            'location',
            'country_code',
            'interest_category',
            'interest_product'
            
        ];
    
        $contactTags['interest_category'] = "interest-category-$this->app";
        $contactTags['interest_product'] = "interest-product-$this->platform";
        $contactTags['purchase_status'] = FREEMIUM;
        $contactTags['plan'] = "plan-free-$this->app";

        $this->activecampaign->addTags($requiredTags, $contactTags);
    }


    //add tags when user is on pricing page
    public function addTagsOnPricingPage(){


    }

}