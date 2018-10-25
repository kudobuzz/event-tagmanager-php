<?php 
class ActiveCampaignLib extends Validation{


    private $ac;

    public function __construct () {

        $this->envCheck();
        $this->ac = new ActiveCampaign(getenv("ACTIVECAMPAIGN_API_URL"), getenv("ACTIVECAMPAIGN_API_KEY"));
    }


    //add contact to activecampaign
    public function addNewContact($requiredDetails, $contactDetails) {

        $this->validate($requiredDetails, $contactDetails);
        $contact_sync = $this->ac->api("contact/sync", $contactDetails);

        if(!(int)$contact_sync->success) {
            // request failed
            throw new Excepgtion($contact_sync->error);
        }

    }

    //add tags to contact on activecampaign
    public function addTags($requiredTags, $contactTags){

        $this->validate($requiredTags, $contactTags);


        $post['email'] = $contactTags['email'];
        unset($contactTags['email']);

        foreach($contactTags as $tag){
            $post['tags'][] = $tag;
        }

        $this->ac->api("contact/tag_add", $post );

    }



}