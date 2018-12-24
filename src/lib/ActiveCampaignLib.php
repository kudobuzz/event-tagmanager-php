<?php

namespace Kudobuzz\EventTagmangerPhp\lib;

use Kudobuzz\EventTagMangerPhp\lib\Validation;

class ActiveCampaignLib extends Validation
{


    private $ac;

    public function __construct()
    {

        $this->envCheck();
        $this->ac = new \ActiveCampaign(getenv("ACTIVECAMPAIGN_API_URL"), getenv("ACTIVECAMPAIGN_API_KEY"));
    }


    //add contact to activecampaign
    public function addNewContact($requiredDetails, $contactDetails)
    {

        $this->validate($requiredDetails, $contactDetails);
        $contact_sync = $this->ac->api("contact/sync", $contactDetails);

        if (!(int)$contact_sync->success) {
            // request failed
            throw new \Exception($contact_sync->error);
        }

        return $contact_sync;

    }

    //add tags to contact on activecampaign
    public function addTags($contactTags)
    {

        $requiredTags = ['email'];

        $this->validate($requiredTags, $contactTags);

        return $this->ac->api("contact/tag_add", $contactTags);

    }

    public function removeTags($contactTags)
    {

        return $this->ac->api("contact/tag_remove", $contactTags);

    }


    public function removeTagsOnUpgrade($email, $app, $platform)
    {

        $contact = $this->ac->api("contact/view?email=$email");
        $data[SINGLEPRODUCT_PAIDPLAN] = array_search(SINGLEPRODUCT_PAIDPLAN, $contact->tags);
        $data[MULTIPLEPRODUCT_PAIDPLAN] = array_search(MULTIPLEPRODUCT_PAIDPLAN, $contact->tags);

        //add tag multiple product paid plan if user has tag single product paid plan and remove sigle product paid plan tag
        if ($data[SINGLEPRODUCT_PAIDPLAN] != fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase) {
            $post['tags'][] = SINGLEPRODUCT_PAIDPLAN;
        }

        $post['email'] = $email;
        $post['tags'][] = FREEMIUM;
        $post['tags'][] = PLAN_FREE . $app;
        $this->ac->api("contact/tag_remove", $post);

        return $data;
    }

    public function getTags($email)
    {

        $contact = $this->ac->api("contact/view?email=$email");
        return $contact->tags;
    }


}