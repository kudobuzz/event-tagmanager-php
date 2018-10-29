Event Tag Manger Library
=========================
This package is a wrapper for kudobuzz tags. Currenlty supports creating contacts and tagging of contacts on Activecampaign. 


Installation
=========================
You can install event-tagmanger-php by downloading (.zip) or cloning the source:

git clone https://github.com/kudobuzz/event-tagmanger-php.git

composer install to install required dependencies

Example Usage
=========================

In your script just include the autoload.php file to load all classes

require_once "src/EventTagManger.php";

Next, create a class instance of EventTagManger:

$et = new EventTagManger(['app'=>'appname','platform'=>'platformname']);

example app name can be `seodoctor` and platfrom can be `shopify`

set env for `ACTIVECAMPAIGN_API_URL` and `ACTIVECAMPAIGN_API_KEY`


adding contact to event tag manger <br><br>
examples.php 
```
require_once "src/EventTagManger.php";

try{


    $eventTagManger = new EventTagManger(['app'=>'seodoctor','platform'=>'shopify']);

    $fields = [
        'email'=>'test@kudobuzz.com',
        'first_name'=>'test',
        'last_name'=>'lastname',
        'phone'=>'12345678'
    ];

    $eventTagManger->addContact($fields);

}catch(Excetpion $e){

    echo $e->getMessage();
}



```
<br><br>
adding tags on install
```

    $requiredTags = [
        'email'=>'elijah@kudobuzz.com',
        'location'=>'Ghana',
        'country_code'=>'GH'
    ];

    $eventTagManger->addTagsOnInstall($requiredTags);
```

You can pass additional tags, by default these tags are added  when you call `addTagsOnInstall` method on install
```
interest-category-{platform}
interest-product-{app}
freemium
plan-free-{app}
```
<br><br>
adding tags on upgrade
```
    $requiredTags = [
        'email'=>'test@kudobuzz.com'
    ];

    $plan = (object) ['name'=>'pro'];
    $test = $eventTagManger->addTagsOnUpgrade($requiredTags,$plan);
```
You can pass additional tags, by default these tags are added on upgrade when you call `addTagsOnUpgrade` method 
```
viewed-subscription-page
initiated-subscription-checkout
paidplan-category-{app}
paidplan-product-{platform}
price-fullprice-paidplan
singleproduct-paidplan/multipleproduct-paidplan
paidplan-{planname}-seodoctor
customer


//by default these tags are removed 
plan-free-{app}
freemium


//set discount key with value 1 to add discount tag to contact $plan = (object) ['name'=>'pro’, ‘discount’=>1];
 discount-paidplan
```
