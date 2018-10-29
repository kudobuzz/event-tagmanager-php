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

examples.php
adding contact to event tag manger
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

adding tags on install
```

    $requiredTags = [
        'email'=>'elijah@kudobuzz.com',
        'location'=>'Ghana',
        'country_code'=>'GH'
    ];

    $eventTagManger->addTagsOnInstall($requiredTags);
```
You can pass additional tages by default these tags are added 
