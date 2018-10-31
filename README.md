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

$eventTagManger = new EventTagManger(['app'=>'appname','platform'=>'platformname']);

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

    $contact = [
        'email'=>'elijah@kudobuzz.com',
        'tags'=>[
            'Ghana',
            'GH',
        ]
    ];

    $eventTagManger->onInstall($contact);
```

You can pass additional tags, by default these tags are added  when you call `addTagsOnInstall` method on install
```
interest-category-{platform}
interest-product-{app}
freemium
plan-free-{app}
```
<br><br>
adding and removing tags on upgrade
```

    $contact = [
        'email'=>'elijah@kudobuzz.com'
    ];
    $plan = (object) ['name'=>'plan name'];
    $eventTagManger->onUpgrade($contact, $plan);
```
You can pass additional tags, by default these tags are added on upgrade when you call `addTagsOnUpgrade` method 
```
viewed-subscription-page
initiated-subscription-checkout
paidplan-category-{app}
paidplan-product-{platform}
price-fullprice-paidplan
singleproduct-paidplan/multipleproduct-paidplan
paidplan-{planname}-{app}
customer
```
<br>When user changes plan from plan A to plan B
```
    $plan = [
        'current'=>['name'=>"A"],
        'new'=>['name'=>'B']
    ];
    
    $eventTagManger->changePlan($contact, $plan);
```


by default these tags are removed <br>
```
plan-free-{app} 
freemium 
```


set discount key with value 1 to add discount tag to contact `$plan = (object) ['name'=>'pro’, ‘discount’=>1];`
```
discount-paidplan
```


<br><br>
adding and removing tags on plan downgrade to free plan
```
    $contact = [
        'email'=>'test@kudobuzz.com'
    ];


    $plan = (object) ['name'=>'plan name'];
    $eventTagManger->downgradeToFreemium($contact,$plan);
```
You can pass additional tags, by default these tags are added on downgrade when you call `downgradeToFreemium` method 
```
plan-free-{app}
freemium
```


by default these tags are removed 
```
viewed-subscription-page
initiated-subscription-checkout
paidplan-category-{app}
paidplan-product-{platform}
price-fullprice-paidplan
singleproduct-paidplan/multipleproduct-paidplan
paidplan-{planname}-{app}
customer
```