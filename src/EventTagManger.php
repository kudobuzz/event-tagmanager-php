<?php 
require_once("vendor/activecampaign/api-php/includes/ActiveCampaign.class.php");
require_once("src/Validation.php");

class EventTagManger extends Validation{


    private $ac;

    public function __construct ($apiKey, $apiURL) {

        $this->ac = new ActiveCampaign($apiKey,  $apiURL);
    }


    //add contact to activecampaign
    public function addContact($contactDetails) {

        $requiredDetails = [
            'email',
            'first_name',
            'last_name',
            'list_id'
        ];

        $this->validate($requiredDetails, $contactDetails);
        $contact_sync = $this->ac->api("contact/sync", $contactDetails);

        if(!(int)$contact_sync->success) {
            // request failed
            throw new Excepgtion($contact_sync->error);
        }

    }

    //add tags to contact on activecampaign
    public function addTagsOnInstall($contactTags){

        $requiredTags = [
            'email',
            'main_category',
            'product_category_interest',
            'product_sub_category_interest',
            'purchase_status',
            'newsletter',
            
        ];
        $this->validate($requiredTags, $contactTags);


        $post['email'] = $userData['email'];
        $post['tags'][] = $userData['main_category'];
        $post['tags'][] = $userData['product_category_interest'];
        $post['tags'][] = $userData['product_sub_category_interest'];
        $post['tags'][] = $userData['purchase_status'];
        $post['tags'][] = $userData['newsletter'];
        $this->ac->api("contact/tag_add", $post );

    }


    //add tags when user is on pricing page
    public function addTagsOnPricingPage(){


    }

}