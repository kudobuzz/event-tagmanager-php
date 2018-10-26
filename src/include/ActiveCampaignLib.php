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

        return $this->ac->api("contact/tag_add", $post );

    }

    public function removeTags($contactTags){

        $post['email'] = $contactTags['email'];
        unset($contactTags['email']);

        foreach($contactTags as $tag){
            $post['tags'][] = $tag;
        }


        return $this->ac->api("contact/tag_remove", $post);
 
    }


    public function removeTagsOnUpgrade($email, $app, $platform){

       $contact =  $this->ac->api("contact/view?email=$email");
       $data[SINGLEPRODUCT_PAIDPLAN] = array_search(SINGLEPRODUCT_PAIDPLAN, $contact->tags);
       $data[MULTIPLEPRODUCT_PAIDPLAN] = array_search(MULTIPLEPRODUCT_PAIDPLAN, $contact->tags);
       
        //add tag multiple product paid plan if user has tag single product paid plan and remove sigle product paid plan tag
        if($data[SINGLEPRODUCT_PAIDPLAN] != fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase){
            $post['tags'][] = SINGLEPRODUCT_PAIDPLAN;
        }

       $post['email'] = $email;
       $post['tags'][] = FREEMIUM;
       $post['tags'][] = PLAN_FREE.$app;
       $this->ac->api("contact/tag_remove", $post );

       return $data;
    }

    public function getTags($email){

        $contact =  $this->ac->api("contact/view?email=$email");
        return $contact->tags;
    }




}