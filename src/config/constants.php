<?php

define("LIST_ID", 1);

define("FREEMIUM", "freemium");
define("VIEWED_SUBSCRIPTION_PAGE", "viewed-subscription-page");
define("INITIATED_SUBSCRIPTION_CHECKOUT", "initiated-subscription-checkout");
define("CANCELLED_SUBSCRIPTION_CHECKOUT", "cancelled-subscription-checkout");
define("SINGLEPRODUCT_PAIDPLAN", "singleproduct-paidplan");
define("PAIDPLAN_CATEGORY", "paidplan-category-");
define("PAIDPLAN_PRODUCT", "paidplan-product-");
define("FULLPRICE_PAIDPLAN", "fullprice-paidplan");
define("DISCOUNT_PAIDPLAN", "discount-paidplan");
define("MULTIPLEPRODUCT_PAIDPLAN", "multipleproduct-paidplan");
define("PAIDPLAN", "paidplan-{planname}-");
define("PLAN_FREE", "plan-free-");
define("CUSTOMER", "customer");

define("ENV_VARIABLES", serialize([
    'ACTIVECAMPAIGN_API_URL', 'ACTIVECAMPAIGN_API_KEY'
]));