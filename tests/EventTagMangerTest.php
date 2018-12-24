<?php

use Kudobuzz\EventTagMangerPhp\EventTagManger;

use PHPUnit\Framework\TestCase;
use Kudobuzz\EventTagmangerPhp\lib\ActiveCampaignLib;

class EventTagMangerTest extends TestCase{

    public function setUp() {
        $this->eventTagManger = new EventTagManger(['app'=>'seodoctor','platform'=>'shopify']);
    }

    public function tearDown() {
		  unset($this->eventTagManger);
    }
   
   
    public function test_event_tags_add_install(){

        $expected = '["interest-category-seodoctor","interest-product-shopify","freemium","plan-free-seodoctor"]';
        $response = json_encode($this->eventTagManger->eventTagsAdd((object) ['name'=>'install']));

        $this->assertEquals(
            $expected,
            $response,
            "get install tags {$response}"
        );
    }

    public function test_event_tags_add_upgrade(){

        $expected = '["paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer"]';

        $plan = (object) ['name'=>'Pro'];
        $tag = (object) ['name'=>'upgrade'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag, $plan));

        $this->assertEquals(
            $expected,
            $response,
            "get upgrade tags {$response}"
        );
    }

    public function test_event_tags_add_downgrade(){

        $expected = '["freemium","plan-free-seodoctor"]';

        $tag = (object) ['name'=>'downgrade'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag));

        $this->assertEquals(
            $expected,
            $response,
            "get downgrade tags {$response}"
        );
    }


    public function test_event_tags_add_uninstall(){

        $expected = '["uninstall-seodoctor"]';

        $tag = (object) ['name'=>'uninstall'];
        $response = json_encode($this->eventTagManger->eventTagsAdd($tag));

        $this->assertEquals(
            $expected,
            $response,
            "get uninstall tags {$response}"
        );
    }

    public function test_event_tags_remove_upgrade(){

        $expected = '["freemium","plan-free-seodoctor"]';

        $tag = (object) ['name'=>'upgrade'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag));

        $this->assertEquals(
            $expected,
            $response,
            "get tags to remove on upgrade {$response}"
        );

    }

    public function test_event_tags_remove_downgrade(){

        $expected = '["paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer","viewed-subscription-page","initiated-subscription-checkout","discount-paidplan","singleproduct-paidplan","multipleproduct-paidplan"]';

        $tag = (object) ['name'=>'downgrade'];
        $plan = (object) ['name'=>'Pro'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag, $plan));

        $this->assertEquals(
            $expected,
            $response,
            "get tags to remove on downgrade {$response}"
        );

    }

    public function test_event_tags_remove_uninstall(){

        $expected = '["paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan--seodoctor","customer","discount-paidplan","singleproduct-paidplan","multipleproduct-paidplan","freemium","plan-free-seodoctor"]';

        $tag = (object) ['name'=>'uninstall'];
        $plan = (object) ['name' => 'some-plan-name'];
        $response = json_encode($this->eventTagManger->eventTagsRemove($tag));

        $this->assertEquals(
            $expected,
            $response,
            "get tags to remove on uninstall {$response}"
        );
    }

    public function test_single_or_multiple_product(){

        $expected = '["paidplan-category-seodoctor","paidplan-product-shopify","fullprice-paidplan","paidplan-pro-seodoctor","customer","singleproduct-paidplan"]';
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
    /**
     * @expectedException \Exception
     */
    public function test_should_return_exception_if_something_is_wrong() {
        $stub = $this->createMock(ActiveCampaignLib::class);

        $stub->method('addNewContact')->will($this->throwException(new \Exception));

        $requiredDetails = [
            'email',
            'first_name',
            'last_name'
        ];
        
        $contact = [
            'email' => 'some@email.com',
            'first_name' => 'Lom',
            'last_name' => 'Se',
            'list_id' => 1
        ];

        $stub->addNewContact($requiredDetails, $contact);
    }
  
}


