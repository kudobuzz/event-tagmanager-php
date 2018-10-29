<?php
class Tags{


    public function all(){
        
        $contactTags[] = VIEWED_SUBSCRIPTION_PAGE;
        $contactTags[] = INITIATED_SUBSCRIPTION_CHECKOUT;
        $contactTags[] = PAIDPLAN_CATEGORY.$this->app;
        $contactTags[] = PAIDPLAN_PRODUCT.$this->platform;
        $contactTags[] = FULLPRICE_PAIDPLAN;
        $contactTags[] = "paidplan-$plan->name-$this->app";
        $contactTags[] = CUSTOMER;
        $contactTags[] = SINGLEPRODUCT_PAIDPLAN;
        $contactTags[] = MULTIPLEPRODUCT_PAIDPLAN;
        $contactTags[] = DISCOUNT_PAIDPLAN;
        $contactTags[] = FREEMIUM;
        $contactTags[] = PLAN_FREE.$this->app;
        
    }

    
}