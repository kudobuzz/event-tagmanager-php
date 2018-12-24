<?php
namespace Kudobuzz\EventTagMangerPhp\lib;


class EventTagMangerlib{


    public function eventTagsAdd($event, $plan = null){
        $tags = [];
        
        if($plan != null){
            $plan->name = strtolower($plan->name);
        }

        if($event->name == 'install'){

            $tags[] = INTEREST_CATEGORY.$this->app;
            $tags[] = INTEREST_PRODUCT.$this->platform;
            $tags = array_merge($tags , $this->freeTags());
        }

        if($event->name == 'upgrade'){
            
            if(empty($plan->name)  || $plan->name == null){
                throw new \Exception("plan name must be set");
            }
            
            $tags = array_merge($tags , $this->planTags($plan ));
            if(isset($event->discount) and $plan->discount == 1){
                $tags[] = DISCOUNT_PAIDPLAN;
            }
        }

        if($event->name == 'downgrade'){
            $tags = array_merge($tags , $this->freeTags());
        }


        if($event->name == 'uninstall'){

            $tags[] = UNINSTALL.$this->app;
        }

        return $tags;
    }

    

    public function eventTagsRemove($event, $plan = null){
        $tags = [];
        
        if($plan != null){
            $plan->name = strtolower($plan->name);
        }

        if($event->name == 'upgrade'){

            $tags = array_merge($tags , $this->freeTags());
        }

        if($event->name == 'downgrade' || $event->name == 'plan_change'){

            if(empty($plan->name)  || $plan->name == null){
                throw new \Exception("plan name must be set");
            }
            
            $tags = array_merge($tags , $this->planTags($plan ));
            $tags[] = VIEWED_SUBSCRIPTION_PAGE;
            $tags[] = INITIATED_SUBSCRIPTION_CHECKOUT;

            if($event->name == 'downgrade' ){
                $tags = array_merge($tags , $this->upgradeTags($plan));
            }
        }

        if($event->name == 'uninstall'){

            $tags = array_merge($tags , $this->planTags($plan ));
            $tags = array_merge($tags , $this->upgradeTags($plan ));
            $tags = array_merge($tags , $this->freeTags());
        }

        return  $tags;
    }

 

    
    public function singleOrMultipleProduct($tagsToAdd, $userTags){

        $data[SINGLEPRODUCT_PAIDPLAN] = array_search(SINGLEPRODUCT_PAIDPLAN, $userTags);
        $data[MULTIPLEPRODUCT_PAIDPLAN] = array_search(MULTIPLEPRODUCT_PAIDPLAN, $userTags);

        if($data[SINGLEPRODUCT_PAIDPLAN] == false && $data[MULTIPLEPRODUCT_PAIDPLAN] == false){
            $tagsToAdd[] = SINGLEPRODUCT_PAIDPLAN;
        }

        //add tag multiple product paid plan if user has tag single product paid plan and remove sigle product paid plan tag
        if($data[SINGLEPRODUCT_PAIDPLAN] != false && $data[MULTIPLEPRODUCT_PAIDPLAN] == false){
    
            $tagsToAdd[] = MULTIPLEPRODUCT_PAIDPLAN;
        }

        return $tagsToAdd;
    }


    public function planTags($plan){
        
        $planName = isset($plan) ? $plan->name : '';

        $tags[] = PAIDPLAN_CATEGORY.$this->app;
        $tags[] = PAIDPLAN_PRODUCT.$this->platform;
        $tags[] = FULLPRICE_PAIDPLAN;
        $tags[] = PAIDPLAN."$planName-$this->app";
        $tags[] = CUSTOMER;

        return $tags;
    }

    public function upgradeTags($plan ){

        $tags[] = DISCOUNT_PAIDPLAN;
        $tags[] = SINGLEPRODUCT_PAIDPLAN;
        $tags[] = MULTIPLEPRODUCT_PAIDPLAN;

        return  $tags;
    }


    public function freeTags(){

        $tags[] = FREEMIUM;
        $tags[] = PLAN_FREE.$this->app;
        return $tags;
    }

   

    
}