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
            'country_code'    
        ];
    
        $contactTags[] = "interest-category-$this->app";
        $contactTags[] = "interest-product-$this->platform";
        $contactTags[] = FREEMIUM;
        $contactTags[] = PLAN_FREE.$this->app;

        $this->activecampaign->addTags($requiredTags, $contactTags);
    }

    //add tags when user is on pricing page
    public function addTagsOnUpgrade($contactTags, $plan){

        $tagsToRemove['email'] = $contactTags['email'];
        $requiredTags = ['email'] ;
    
        $contactTags[] = VIEWED_SUBSCRIPTION_PAGE;
        $contactTags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
        $contactTags[] = PAIDPLAN_CATEGORY.$this->app;
        $contactTags[] = PAIDPLAN_PRODUCT.$this->platform;
        $contactTags[] = FULLPRICE_PAIDPLAN;
        $contactTags[] = "paidplan-$plan->name-$this->app";
        $contactTags[] = CUSTOMER;

        if(isset($plan->discount) and $plan->discount == 1){
            $contactTags[] = DISCOUNT_PAIDPLAN;
        }

        $data = $this->activecampaign->removeTagsOnUpgrade($contactTags['email'], $this->app, $this->platform);

        if($data[SINGLEPRODUCT_PAIDPLAN] === fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase){
            $contactTags[] = SINGLEPRODUCT_PAIDPLAN;
        }

        //add tag multiple product paid plan if user has tag single product paid plan and remove sigle product paid plan tag
        if($data[SINGLEPRODUCT_PAIDPLAN] != fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase){
            $contactTags[] = MULTIPLEPRODUCT_PAIDPLAN;
        }
        

        $this->activecampaign->addTags($requiredTags, $contactTags);

        return ['existingTags'=>$data, 'addedTags'=> $contactTags];
    }

    //get user tags
    public function getTags($email){
        
        return  $this->activecampaign->getTags($email);;
    }


    public function downgradeToFreemium($contactTags,  $plan){
        $requiredTags = ['email'];

        $tags['email'] = $contactTags['email'];
        $tags[] = VIEWED_SUBSCRIPTION_PAGE;
        $tags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
        $tags[] = PAIDPLAN_CATEGORY.$this->app;
        $tags[] = PAIDPLAN_PRODUCT.$this->platform;
        $tags[] = FULLPRICE_PAIDPLAN;
        $tags[] = "paidplan-$plan->name-$this->app";
        $tags[] = CUSTOMER;
        $tags[] = DISCOUNT_PAIDPLAN;
        $tags[] = SINGLEPRODUCT_PAIDPLAN;
        $tags[] = MULTIPLEPRODUCT_PAIDPLAN;

       

        $this->activecampaign->removeTags($tags);
        $contactTags[] = FREEMIUM;
        $contactTags[] = PLAN_FREE.$this->app;

        $this->activecampaign->addTags($requiredTags, $contactTags);
    }

    public function onUninstall($contactTags,  $plan){
        $requiredTags = ['email'];

        $uninstallTags['email'] = $contactTags['email'];
        $uninstallTags[] = VIEWED_SUBSCRIPTION_PAGE;
        $uninstallTags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
        $uninstallTags[] = PAIDPLAN_CATEGORY.$this->app;
        $uninstallTags[] = PAIDPLAN_PRODUCT.$this->platform;
        $uninstallTags[] = FULLPRICE_PAIDPLAN;
        $uninstallTags[] = "paidplan-$plan->name-$this->app";
        $uninstallTags[] = CUSTOMER;
        $uninstallTags[] = DISCOUNT_PAIDPLAN;
        $uninstallTags[] = SINGLEPRODUCT_PAIDPLAN;
        $uninstallTags[] = MULTIPLEPRODUCT_PAIDPLAN;
        $uninstallTags[] = FREEMIUM;
        $uninstallTags[] = PLAN_FREE.$this->app;
        $this->activecampaign->removeTags($uninstallTags);

        $contactTags[] = UNINSTALL_SEODOCTOR;
        $this->activecampaign->addTags($requiredTags, $contactTags);


    }

}