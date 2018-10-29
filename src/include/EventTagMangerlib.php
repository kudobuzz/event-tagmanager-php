<?php
class EventTagMangerlib{


    public function eventTagsAdd($event){


        if($event->name == 'install'){

            $tags[] = INTEREST_CATEGORY.$this->app;
            $tags[] = INTEREST_PRODUCT.$this->platform;
            $tags[] = FREEMIUM;
            $tags[] = PLAN_FREE.$this->app;
        }

        if($event->name == 'upgrade'){
            
            $tags[] = VIEWED_SUBSCRIPTION_PAGE;
            $tags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
            $tags[] = PAIDPLAN_CATEGORY.$this->app;
            $tags[] = PAIDPLAN_PRODUCT.$this->platform;
            $tags[] = FULLPRICE_PAIDPLAN;
            $tags[] = PAIDPLAN."$plan->name-$this->app";
            $tags[] = CUSTOMER;
            if(isset($event->discount) and $plan->discount == 1){
                $tags[] = DISCOUNT_PAIDPLAN;
            }
        }

        if($event->name == 'downgrade'){

            $tags[] = FREEMIUM;
            $tags[] = PLAN_FREE.$this->app;
        }


        if($event->name == 'uninstall'){

            $tags[] = UNINSTALL.$this->app;
        }





        return $tags;


    }

    public function eventTagsRemove(){
        
        if($event->name == 'upgrade'){

            $tags[] = FREEMIUM;
            $tags[] = PLAN_FREE.$this->app;
        }

        if($event->name == 'downgrade'){
            
            $tags[] = VIEWED_SUBSCRIPTION_PAGE;
            $tags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
            $tags[] = PAIDPLAN_CATEGORY.$this->app;
            $tags[] = PAIDPLAN_PRODUCT.$this->platform;
            $tags[] = FULLPRICE_PAIDPLAN;
            $tags[] = PAIDPLAN."$plan->name-$this->app";
            $tags[] = CUSTOMER;
            $tags[] = DISCOUNT_PAIDPLAN;
            $tags[] = SINGLEPRODUCT_PAIDPLAN;
            $tags[] = MULTIPLEPRODUCT_PAIDPLAN;

        }

        if($event->name == 'uninstall'){

            $tags[] = VIEWED_SUBSCRIPTION_PAGE;
            $tags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
            $tags[] = PAIDPLAN_CATEGORY.$this->app;
            $tags[] = PAIDPLAN_PRODUCT.$this->platform;
            $tags[] = FULLPRICE_PAIDPLAN;
            $tags[] = PAIDPLAN."$plan->name-$this->app";
            $tags[] = CUSTOMER;
            $tags[] = DISCOUNT_PAIDPLAN;
            $tags[] = SINGLEPRODUCT_PAIDPLAN;
            $tags[] = MULTIPLEPRODUCT_PAIDPLAN;
            $tags[] = FREEMIUM;
            $tags[] = PLAN_FREE.$this->app;
        }


        return  $tags;
    }

    public function singleOrMultipleProduct($tagsToAdd, $userTags){

        $data[SINGLEPRODUCT_PAIDPLAN] = array_search(SINGLEPRODUCT_PAIDPLAN, $userTags);
        $data[MULTIPLEPRODUCT_PAIDPLAN] = array_search(MULTIPLEPRODUCT_PAIDPLAN, $userTags);

        if($data[SINGLEPRODUCT_PAIDPLAN] === fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase){
            $tagsToAdd['tags'][] = SINGLEPRODUCT_PAIDPLAN;
        }

        //add tag multiple product paid plan if user has tag single product paid plan and remove sigle product paid plan tag
        if($data[SINGLEPRODUCT_PAIDPLAN] != fase || $data[MULTIPLEPRODUCT_PAIDPLAN] === fase){
            $tagsToAdd['tags'][] = MULTIPLEPRODUCT_PAIDPLAN;
        }

        return $tagsToAdd;
    }

    
}