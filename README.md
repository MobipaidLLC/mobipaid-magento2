﻿=== Mobipaid ===

Contributors: mobipaid
Tags: credit card, mobipaid, google pay, apple pay, nedbank, payment method, payment gateway
Requires at least: 2.3.0
Tested up to: 2.4.6
Requires PHP: 7.2
Stable tag: 1.0.8
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Payments over multiple channels

== Description ==

= Because you want more than just a shopping cart experience =

* Take payments online and offline
* Use your preferred merchant service provider
* Promote directly on Facebook, LinkedIn and Twitter

= Changing the way you take card-not-present payments. =

Mobipaid is a single card-not-present payment platform that allows you to accept payments in a variety of ways: SEPA, Paypal, Credit/Debit Card, Nedbank EFT, google pay, apple pay and more. Add Mobipaid to your shopping cart for easy and secure payments during checkout, or use your Mobipaid portal to deliver payment requests to your customers using text messaging (SMS), email, social media, and QR codes.

Mobipaid is the best payment solution available for merchants who need payment flexibility, or if your business has grown beyond just eCommerce and the service you offer requires you to take payments anywhere, anytime.
 
== Features ==

* Accept payments via Mobipaid.
* Partial / Full refund.
 
== Localization ==

* English (default) - always included.
* Arabic (ar)
* Danish (da_DK)
* German (de_DE)
* English(US) (en_US)
* Spanish(Spain) (es_ES)
* Finnish (fi)
* French (fr_FR)
* Indonesian (id_ID)
* Italian (it_IT)
* Japanese (ja)
* Korean (ko_KR)
* Dutch (nl_NL)
* Polish (pl_PL)
* Portuguese(Portugal) (pt_PT)
* Russian (ru_RU)
* Swedish (sv_SE)
* Turkish (tr_TR)
* Chinese(China) (zh_CN)




== Installation ==

Note: Magento 2.3.0 - 2.4.6 must be installed for this plugin to work.

== Install the module using a file upload and SSH commands ==

1. Download the plugin zip file from Magento Market place.
2. Unzip the plugin file  and then copy all files inside uunzip folder into this folder: your_magento_2_root/app/code/Mobipaid/Mobipaid
3. To check the plugin status, run the command:
php bin/magento module:status
4. To enable the plugin, run the command:
php bin/magento module:upgrade
5. Optionally, check the plugin status as in step 3.

If you are running Magento 2 in production mode, also run the following commands in this order:
php bin/magento cache:clean
php bin/magento cache:flush
php bin/magento setup:static-content:deploy
php bin/magento indexer:reindex




== Frequently Asked Questions ==

= Does this require an SSL certificate? =

Yes! In Live Mode, an SSL certificate must be installed on your site to use Mobipaid.

= Does this support both production mode and sandbox mode for testing? =

Yes, it does - production and sandbox mode is driven by the API Access keys you use.

= Where can I can get support? =

You can contact developer with this [link](https://mobipaid.com/contact/).

