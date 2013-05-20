BrilliantRetail Extended Plugin
===========

BrilliantRetail plugin to extend some functionality

Only a couple of functions at the moment...

1) Output options in raw format, for use with a Quantity Discounts options setup we have for a customer, so a bit specific

2) A function to return raw product data for us with the above function

3) Set a default country in the Country options drop down


Usage
------------

### Countries Select
{exp:br_extended:countries name=“br_shipping_country” id=“br_shipping_country” class=“required” value=”{br_shipping_country}” default=“GB”}
		