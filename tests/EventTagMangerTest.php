<?php
require_once "src/EventTagManger.php";

use PHPUnit\Framework\TestCase;

class EventTagMangerTest extends TestCase{

    public function setUp() {
        $this->eventTagManger = new EventTagManger(['app'=>'seodoctor','platform'=>'shopify']);
    }

    public function tearDown() {
		  unset($this->eventTagManger);
    }
   
   
    public function testeventTagsAddInstall(){

        $expected = '["interest-category-seodoctor","interest-product-shopify","freemium","plan-free-seodoctor"]';
        $response = json_encode($this->eventTagManger->eventTagsAdd((object) ['name'=>'install']));

        $this->assertEquals(
            $expected, 
            $response,
            "get install tags {$response}"
        );
    }

    public function testeventTagsAddUpgrade(){

        $expected = '["viewed-subscription-page","initiated-subscription-checkout","paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer"]';
        
        $plan = (object) ['name'=>'Pro'];
        $tag = (object) ['name'=>'upgrade'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag, $plan));

        $this->assertEquals(
            $expected, 
            $response,
            "get upgrade tags {$response}"
        );
    }

    public function testeventTagsAdddowngrade(){

        $expected = '["freemium","plan-free-seodoctor"]';
        
        $tag = (object) ['name'=>'downgrade'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag));

        $this->assertEquals(
            $expected, 
            $response,
            "get downgrade tags {$response}"
        );
    }


    public function testeventTagsAddUninstall(){

        $expected = '["uninstall-seodoctor"]';
        
        $tag = (object) ['name'=>'uninstall'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag));

        $this->assertEquals(
            $expected, 
            $response,
            "get uninstall tags {$response}"
        );
    }

    public function testeventTagsRemoveUpgrade(){

        $expected = '["freemium","plan-free-seodoctor"]';
        
        $tag = (object) ['name'=>'upgrade'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag));

        $this->assertEquals(
            $expected, 
            $response,
            "get tags to remove on upgrade {$response}"
        );

    }

    public function testeventTagsRemoveDowngrade(){

        $expected = '["viewed-subscription-page","initiated-subscription-checkout","paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer","discount-paidplan","singleproduct-paidplan","multipleproduct-paidplan"]';
        
        $tag = (object) ['name'=>'downgrade'];
        $plan = (object) ['name'=>'Pro'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag, $plan));

        $this->assertEquals(
            $expected, 
            $response,
            "get tags to remove on downgrade {$response}"
        );

    }

    public function testeventTagsRemoveUninstall(){

        $expected = '["viewed-subscription-page","initiated-subscription-checkout","paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan--seodoctor","customer","discount-paidplan","singleproduct-paidplan","multipleproduct-paidplan","freemium","plan-free-seodoctor"]';
        
        $tag = (object) ['name'=>'uninstall'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag));

        $this->assertEquals(
            $expected, 
            $response,
            "get tags to remove on uninstall {$response}"
        );
    }
       
    public function testsingleOrMultipleProduct(){

        $expected = '["viewed-subscription-page","initiated-subscription-checkout","paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer","singleproduct-paidplan"]';
        $tag = (object) ['name'=>'upgrade'];
        $plan = (object) ['name'=>'Pro'];

        $contact['tags'] = $this->eventTagManger->eventTagsAdd($tag, $plan);
        $userTags = ["freemium","interest-category-seodoctor","interest-product-shopify","plan-free-seodoctor","Ghana","GH"];
        $response = json_encode($this->eventTagManger->singleOrMultipleProduct($contact['tags'], $userTags));


        $this->assertEquals(
            $expected, 
            $response,
            "get tags to remove on uninstall {$response}"
        );
    }
  
}


