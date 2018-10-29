<?php 
require_once("src/require.php");
class EventTagManger extends EventTagMangerlib {


    public $activecampaign;
    public $platform;
    public $app;

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
    public function onInstall($contact){

        $tagsToAdd = $this->eventTagsAdd((object) ['name'=>'install']);
        $contact['tags']  = array_merge($contact['tags'] , $tagsToAdd);
        $this->activecampaign->addTags($contact);
    }

    //add tags when user is on pricing page
    public function onUpgrade($contact, $plan){

        $removeTags['email'] = $contact['email'];
        $removeTags['tags'] = $this->eventTagsRemove((object) ['name'=>'upgrade']);
        $this->activecampaign->removeTags($removeTags);

        $contact['tags'] = $this->eventTagsAdd((object) ['name'=>'upgrade']);
        $contact['tags'] = $this->singleOrMultipleProduct($contact['tags'], $this->getTags($contact['email']));
        $this->activecampaign->eventTagsAdd($contact);

    }


    public function downgradeToFreemium($contact,  $plan){

        $removeTags['email'] = $contact['email'];
        $removeTags['tags'] = $this->eventTagsRemove((object) ['name'=>'downgrade']);
        $this->activecampaign->removeTags($removeTags);
       

        $contact['tags'] = $this->eventTagsAdd((object) ['name'=>'downgrade']);
        $this->activecampaign->addTags($contact);
    }

    public function onUninstall($contact,  $plan){

        $removeTags['email'] = $contact['email'];
        $removeTags['tags'] = $this->eventTagsAdd((object) ['name'=>'downgrade']);
        $this->activecampaign->removeTags($removeTags);

        $contact['tags'] = $this->eventTagsAdd((object) ['name'=>'uninstall']);
        $this->activecampaign->addTags($contact);


    }

    public function addTag($contact){

        $this->activecampaign->addTags($contact);
    }

    //get user tags
    public function getTags($email){
    
        return  $this->activecampaign->getTags($email);;
    }

}