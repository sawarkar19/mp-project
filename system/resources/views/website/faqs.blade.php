@extends('layouts.website')

@section('title', 'FAQs for MouthPublicity.io: Get Answers to Your Questions')
@section('description', 'Frequently Asked Questions - MouthPublicity.io')
@section('keywords', 'MouthPublicity.io Frequently Asked Questions, MouthPublicity.io FAQs')
{{-- @section('image', '') --}}

@section('end_head')

@endsection

@section('content')
<section id="faqs">
    <div class="container">
        {{-- Breadcrumb Section --}}
        @php
            $bcrm = array(
                array('name' => 'FAQs', 'link' => false),
            );
        @endphp
        @include('website.components.breadcrumb', $bcrm)
    </div>
    <div class="container">
        {{-- Banner Image  --}}
        <div class="text-center pt-3">
            <img src="{{ asset('assets/front/images/faq-banner.svg') }}" class="w-100" style="max-width:350px" alt="MouthPublicity.io FAQ">
        </div>

        {{-- Tital and search bar --}}
        <div class="row justify-content-center align-items-center mt-5">
            <div class="col-xl-7 col-lg-8 text-center">  
                <div>
                    <h1 class="font-800">Frequently Asked Questions</h1>
                    <p class="mb-4 font-600">You can also browse the keywords below to find what you are looking for.</p>
                </div>

                <div class="form-type-one">
                    <div class="form-group search">  
                        <input type="text" class="form-control shadow" id="faq_search" placeholder="Find question">
                    </div>
                </div>
            </div>
        </div> 

        @php

        $faqs = array(
            array(
                'que' => 'Can I register twice with the same details on MouthPublicity?',
                'ans' => 'No, the system does not allow you to register with the same details twice.'
            ),
            array(
                'que' => 'How to create a page on social media using MouthPublicity?',
                'ans' => 'No, with MouthPublicity, you can\'t create any social media pages. You can just add and track social media activity to your offer page or social media platforms through MouthPublicity.'
            ),
            array(
                'que' => 'How to Recharge a MouthPublicity Account?',
                'ans' => 'In case you are logged in go to profile (on top right corner) > Recharge Now > Just go to the Pricing page, select the amount according to your business need and you are all set to go live with your Business features. In case you logged out then you can directly recharge from the <a href="'.url('pricing').'"> pricing page.</a>'
            ),
            array(
                'que' => 'How to use Pro Features?',
                'ans' => 'Recharge with MouthPublicity.io to use Pro Features.'
            ),
            array(
                'que' => 'How should I upgrade my plan?',
                'ans' => 'We are happy, you decided to walk one step ahead. You can visit MouthPublicity.io and review pricing to upgrade.'
            ),
            array(
                'que' => 'I am already having an online business so how is this concept going to help me?',
                'ans' => 'MouthPublicity.io is built with the concept of offering true power-of-mouth publicity media to all businesses. This tool will individually just work on increasing business reach and will also give detailed analytics of your brand reach.'
            ),
            array(
                'que' => 'When exactly can a customer redeem the discount?',
                'ans' => 'Customers can redeem discounts, once they complete the challenge set for instant or share challenge.'
            ),
            array(
                'que' => 'Are we supposed to provide a Coupon/redeem code to customers?',
                'ans' => 'As a business owner, you don\'t have to provide any coupon/redeem code, as your customer completes the challenge they will receive a coupon/redeem code from MouthPublicity, which will be redeemed upon the completion of the challenge.'
            ),
            array(
                'que' => 'Is there any refund policy?',
                'ans' => 'Sorry, we won\'t provide any refund policy.',
            ),
            array(
                'que' => 'How can I share an offer with the customer?',
                'ans' => 'As MouthPublicity provides QR code facility so that customer can directly scan and get the link or you can manually share the offer via send challenge'
            ),
            array(
                'que' => 'Do I have to redeem to everyone forwarding the link in their network?',
                'ans' => 'No! You just have to provide an offer to your primary customers, who have subscribed to an ongoing instant challenge, and completed the target you have set.'
            ),
            array(
                'que' => 'Will you notify me when the challenge is completed by the customer?',
                'ans' => 'No! however, you can track customer\'s targets and achievements for a respective offer on the MouthPublicity dashboard. Whereas your customer will receive the redemption code from MouthPublicity as they complete the challenge and will come to avail the offer to you.'
            ),
            array(
                'que' => 'What is MouthPublicity.io?',
                'ans' => 'MouthPublicity.io is a mouth publicity  tool to increase your brand reach by sharing your business content on customer\'s WhatsApp. One can easily register their business on MouthPublicity.io and create and share their business offers with their customers through MouthPublicity.io.'
            ),
            array(
                'que' => 'What is an Instant Challenge?',
                'ans' => 'Instant Challenge is the fastest way to grow your social media presence. In an Instant Challenge, you need to provide customers with an instant benefit on their recent purchase and ask them to visit and follow your social media pages.',
            ),
            array(
                'que' => 'What is the Share Challenge?',
                'ans' => 'Share Challenge provides you with different features like Cash Per Click, Fixed Amount, Percentage Discount and are the best way to grow your brand reach. In this, your customer subscribed to instant challenge will receive the offer link via WhatsApp and ask them to share it in their network with some specified click target. Once the challenge is completed by the customer, you can offer them future benefits on the next purchase.',
            ),
            array(
                'que' => 'How is it better than digital marketing?',
                'ans' => 'MouthPublicity.io is the organic mouth publicity media marketing tool that runs on the idea of organically spreading the word for business through its customer and growing brand reach. MouthPublicity.io also offers a detailed analytical view of each penny invested and helps you in micro-level targeting of customers. Whereas Digital Marketing helps your market your business on a vast level.',
            ),
            array(
                'que' => 'Can your MouthPublicity.io Messaging API be integrated with any online billing software?',
                'ans' => 'Our MouthPublicity.io Messaging API can be integrated with the specific billing software that supports API integration.',
            ),
            array(
                'que' => 'How can I integrate MouthPublicity.io Messaging API with my POS system/billing software?',
                'ans' => 'Whenever you subscribe to Mouth Publicity.ios Messaging API, a unique API Key will be generated which you can replace or integrate with the help of your POS/ Billing Software vendor.',
            ),
            array(
                'que' => 'Is my data safe with MouthPublicity.io?',
                'ans' => 'Yes, your data is safe with MouthPublicity.io. For more details click on Privacy policy.',
            ),
            array(
                'que' => 'I don\'t have a website, can I still use MouthPublicity.io?',
                'ans' => 'Yes, you can still use MouthPublicity.io and create offers by using customised templates.',
            ),
            array(
                'que' => 'I don\'t have social media pages, can I use MouthPublicity.io?',
                'ans' => 'Yes, you can use MouthPublicity.io to create offer content and promote it to your customer base on their WhatsApp.',
            ),
            array(
                'que' => 'Can I use MouthPublicity.io to increase my social media followers?',
                'ans' => 'A big Yes! With MouthPublicity.io, you can create instant challenges and share them with your customer and increase your social media followers.',
            ),
            array(
                'que' => 'Can I use my website URL to share my promotional offers',
                'ans' => 'Yes, You can use your website URL for creating and promoting your business offer.',
            ),
            array(
                'que' => 'If I\'m paying for a monthly membership, do I get access to all your features of MouthPublicity.io?',
                'ans' => 'Yes, you will get access to all our features. You can review the pricing.',
            ),
            array(
                'que' => 'Is there any amount required to get registered on MouthPublicity.io?',
                'ans' => 'No, you can freely get registered just by entering details like your name, contact number, and email and and access all the features free for lifetime.',
            ),
            array(
                'que' => 'How does your system prevent contestants from cheating the system?',
                'ans' => 'We have a track record of each click from the user and it is visible on the dashboard, while redeeming the offer he/she has to share their unique code which will be received on their number. Thus avoiding cheating from the system. For more details, you can check our privacy policy here.',
            ),
            array(
                'que' => 'How does an offer look on mobile?',
                'ans' => 'Mobile has been a priority to promote offers. Our templates are mobile-friendly which makes your offers look amazing on mobile! Each template is designed to be mobile-friendly.'
            ),
            array(
                'que' => 'Can MouthPublicity.io help me get Twitter, Facebook, or Instagram followers?',
                'ans' => 'Yes! You can grow your social media followers by Instant challenge campaign. You select Instant challenge and can ask your audience to like/follow your social media pages and offer them instant benefits.'
            ),
            array(
                'que' => 'Can I customise my offers?',
                'ans' => 'Yes, MouthPublicity.io allows customization for your offers. It has multiple pre-designed templates you can choose according to your business needs and create attractive offers.'
            ),
            array(
                'que' => 'What if I am unable to open or access the link?',
                'ans' => 'The error in Opening a link or accessing it will occur only and only if there is an internet connectivity issue. Kindly check your network connectivity once, if you still face the issue please contact 07887882244'
            ),
            array(
                'que' => 'How to Send Challenges on WhatsApp?',
                'ans' => 'Once you have designed the offer go to create challenges and create the challenge you want according to business need and then to share it go to send the challenge, you can print the QR code or manually enter the details and share the offer. You can share the link by adding a WhatsApp number.'
            ),
            array(
                'que' => 'How can I reset my Credentials?',
                'ans' => 'Click on forget the password, enter the registered email id or contact number, you will then receive a link on your registered email id and WhatsApp number, next reset the password Go to the link, reset the new password and you are all set to go with your new password.'
            ),
            array(
                'que' => 'How to track the clicks of subscribed customers?',
                'ans' => 'Go to MouthPublicity.io, click on the dashboard on the admin panel, Have a look at the clicks of all your customers right there on a single dashboard.'
            ),
            array(
                'que' => 'What are the benefits I would get after registration?',
                'ans' => 'Once you are registered with MouthPublicity.io, you can design challenges for your customers, and social posts too, for your social media followers. you can grow your customer reach, and also grow your social media presence.'
            ),
            array(
                'que' => 'What is the validity of the link?',
                'ans' => 'There is no validity of the link. If the offer ends and the customer comes to avail of the benefit. You need to offer them the same offer they are subscribed to, to benefit at that time.'
            ),
            array(
                'que' => 'How can I change the offer?',
                'ans' => 'You can stop the active offer and then create a new offer.'
            ),
            array(
                'que' => 'Can I Use MouthPublicity to Promote offers?',
                'ans' => 'Yes definitely! You can use MouthPublicity.io to easily create and promote your business offers.'
            ),
            array(
                'que' => 'How to change my location?',
                'ans' => 'Please go to settings and change your location.'
            ),
            array(
                'que' => 'How to track the customer moves?',
                'ans' => 'You can observe and analyse all statistics of your customers on the dashboard.'
            ),
            array(
                'que' => 'I don\'t use WhatsApp. Can I use MouthPublicity.io?',
                'ans' => 'Yes of course, you can use SMS services to send offers on MouthPublicity.io.'
            ),
            array(
                'que' => 'What is the benefit of social posts?',
                'ans' => 'Social posts will help you to increase your social media presence.',
            ),
            array(
                'que' => 'Do I have to pay for a social post',
                'ans' => 'This is free from MouthPublicity with the plan.',
            ),
            array(
                'que' => 'What is meant by unique & Total click?',
                'ans' => 'Unique Click - If a person opens the offer link once it is calculated as a unique click.<br>Total Click - If a person opens the offer link one or more than time is calculated as total click.',
            ),
            array(
                'que' => 'Why am I unable to see Today\'s clicks statistics?',
                'ans' => 'Statistics show present data on the next day or you can see the last 7 days data at a time.',
            ),
            array(
                'que' => 'Where can I check my plan\'s expiry date?',
                'ans' => 'In the admin dashboard in the statements option.',
            ),
            array(
                'que' => 'Can I add a video from YouTube to my offer?',
                'ans' => 'Yes, you can add video while creating an offer by using our offer template.',
            ),
            array(
                'que' => 'What is the use of the suspended option in the employee dashboard?',
                'ans' => 'For removing the employee from the employee list.',
            ),
            array(
                'que' => 'Whom should I approach in case of MouthPublicity.io product query?',
                'ans' => 'If you have any questions, just feel Personal to talk to us 24x7 i.e., anytime, from anywhere. Connect with us on care@mouthpublicity.io or 07887882244.',
            ),
            array(
                'que' => 'Can MouthPublicity.io be used for any small-scale industry?',
                'ans' => 'Yes, You can use MouthPublicity.io for small as well as large-scale industries.',
            ),
            array(
                'que' => 'What is the use of User Management?',
                'ans' => 'It provides a platform for multiple billing systems and employee details.',
            ),
            array(
                'que' => 'Can employees create an offer?',
                'ans' => 'No, the employee can share the offers but can not create offers.',
            ),
            array(
                'que' => 'Do employees need a WhatsApp Number to log in to an account?',
                'ans' => 'No, not required to be a WhatsApp user. but a WhatsApp number is mandatory to share the offers and posts.',
            ),
            array(
                'que' => 'What is scheduled and unscheduled?',
                'ans' => 'If your current (On going) offer is running with a particular date then it is called schedule. If your Up coming offer is running, without any specific date then it is called unschedule.',
            ),
            array(
                'que' => 'How to design an Offer?',
                'ans' => '<p>There are three ways to create an offer</p><ul><li>By using template</li><li>Custom offer – My website or Upload image</li></ul><p>According to your choice you can customise the offers by using templates, after that continue to offer details page. Here you have to put your offer title and description with start date and end date. After completing all the processes your offer will be created.</p><p>Same procedure with custom offer as well, but in a custom offer you have an option to put the URL of your website.</p>',
            ),
            array(
                'que' => 'How to share the "Instant Challenge"?',
                'ans' => 'In instant challenge reward setting is most crucial after that you are able to send the challenge. There are two ways to send the instant challenge to the customer via send challenge or By scanning QR code.',
            ),
            array(
                'que' => 'How to share “share challenge”?',
                'ans' => 'In share challenge reward setting is crucial, without setting you are unable to send the share challenge. After that auto share setting is also significant before sharing the challenge. <br>Here, business owners are able to set a particular time duration on which timing duration share challenge is sent to the customer. 2hrs, 6hrs, 12hrs, 24hrs, 48hrs, 72hrs etc. As per setting, customers will get a share challenge.',
            ),
            array(
                'que' => 'How to upload the contacts in MouthPublicity.io?',
                'ans' => 'In the dashboard contact section is available, here you have to import the contact list and download the files then your data will be updated. After that you can see there are two options available. Existing group and Selected group, select any one browse the file and upload it.',
            ),
            array(
                'que' => 'What is a v-card?',
                'ans' => 'V-card means a visiting card of the business owner. If the offer expires and the customer opens the offer link then the v-card is visible to the customer instead of the offer. ',
            ),
            array(
                'que' => 'What happens when my offer expires?',
                'ans' => 'When your offer expires and then the v-card is visible on offer link to customer if the customer is subscribed to the offer.',
            ),
            array(
                'que' => 'How to download the QR code of my offer?',
                'ans' => 'In the instant challenge section, a QR option is available. There are 3-4 designs available on QR, and select the design. Business Owners are able to download QR and print it also.<br>Here is one condition: your reward setting and instant task will be updated after that you are able to download the QR code.',
            ),
            array(
                'que' => 'What if my offer is running and my recharge has expired?',
                'ans' => 'You can recharge immediately or use it for free. It\'s up to you.',
            ),
            array(
                'que' => 'Can I use Mouthpublicity.io for advertising?',
                'ans' => 'You cannot launch or run any advertisement services with mouthpublicity.io as it is a pure organic marketing platform developed to amplify word-of-mouth. Although you can use your advertising digital content (Banner image /Video/Flyer)  to launch your word-of-mouth marketing campaign to reach new potential customers.',
            ),
            array(
                'que' => 'How to connect my whatsapp with MouthPublicity.io?',
                'ans' => '<ol><li>Open your WhatsApp app on your mobile device.</li><li>Click on the top right corner.</li><li>Select "Linked Device" and then click on "link a device".</li><li>Scan the MouthPublicity.io QR code with your WhatsApp scanner.</li><li>Your WhatsApp will now be connected to MouthPublicity.io.</li></ol>',
            ),
        );



        // $faqs = array(
        //     array(
        //         'que' => 'Can I register twice with the same details on MouthPublicity.io?',
        //         'ans' => 'No, the system does not allow you to register with the same details twice.'
        //     ),
        //     array(
        //         'que' => 'How to create a page on social media using MouthPublicity.io?',
        //         'ans' => 'No, with MouthPublicity.io, you can\'t create any social media pages. You can just add and track social media activity to your offer page or social media platforms through MouthPublicity.io.'
        //     ),
        //     array(
        //         'que' => 'How can I buy a premium subscription plan for MouthPublicity.io?',
        //         'ans' => 'MouthPublicity.io doesn\'t come  in a specific paid premium plan, all the core features/products of MouthPublicity.io are free. Although, you have to recharge to use the core products to the full extent. Check out the minimum recharge cost at <a href="'.url('pricing').'">Pricing</a> page.'
        //     ),
        //     array(
        //         'que' => 'What are the minimum and maximum recharge amount price I have to pay for using MouthPublicity.io at full extent?',
        //         'ans' => 'The minimum recharge amount is ₹100 and maximum recharge is up to ₹1Lac. You can access pro features with minimum recharge also but we do recommend you to recharge at least ₹2000 to experience some measurable impact on your mouth publicity.'
        //     ),
        //     array(
        //         'que' => 'I am already having an online business so how is this concept going to help me?',
        //         'ans' => 'MouthPublicity.io is built with the concept of offering true power of mouth publicity media to all businesses. This tool will individually just work on increasing business reach and will also give detailed analytics of your brand reach.'
        //     ),
        //     array(
        //         'que' => 'When exactly can a customer avail the discount?',
        //         'ans' => 'Customers can avail of discounts, once they completed the challenge set for instant or share challenge.'
        //     ),
        //     array(
        //         'que' => 'Are we supposed to provide a Coupon code to customers?',
        //         'ans' => 'As a business owner, you don\'t have to provide any coupon code, as your customer completes the challenge they will receive a coupon code from MouthPublicity.io, which will be availed/redeemed on the next purchase.'
        //     ),
        //     array(
        //         'que' => 'Is there any refund policy?',
        //         'ans' => 'Yes We do have a refund policy as Prorata basis. Refer <a href="'.url('terms-and-conditions').'">terms and conditions</a> for more details.'
        //     ),
        //     array(
        //         'que' => 'How can I share an offer with the customer?',
        //         'ans' => 'There are two ways to share offer to your customers: <br>
        //         <br><b>1. By entering your customers WhatsApp number.</b><br>
        //         &nbsp &nbsp &nbsp Go to the send challenges section, enter the customer\'s details including his/her WhatsApp number and click on the send button. Your customer will receive the offer challenge link via SMS, WhatsApp or both. For more details refer: <a href="'.url('how-it-works').'">How MouthPublicity.io Works</a> & <a href="'.url('documentation/send-challenges').'"> Documentation page.</a>
        //         <br> <br>
        //         <b>2. By scanning generated QR Code through your customers</b><br>
        //         &nbsp &nbsp &nbsp You can simply ask your customers to scan QR code (generated after offer creation) through his/her mobile QR scan app. This will automatically send a created offer challenge link to her/his sms/whatsapp.  <a href="'.url('how-it-works').'">How MouthPublicity.io Works</a> & <a href="'.url('documentation/send-challenges').'"> Documentation page.</a>'
        //     ),
        //     array(
        //         'que' => 'Do I have to redeem to every person who is forwarding the link in their network?',
        //         'ans' => 'No! You just have to provide an offer to your primary customers, who have visited your shop, have received a link from your side, and completed the target you have set.'
        //     ),
        //     array(
        //         'que' => 'Will you notify me when the challenge is completed by the customer?',
        //         'ans' => 'No! however, you can track customer\'s targets and achievements for a respective offer on the MouthPublicity.io dashboard. Whereas your customer will receive the redeem code from MouthPublicity.io as they complete the challenge and will come to avail the offer to you.'
        //     ),
        //     array(
        //         'que' => 'What is MouthPublicity.io?',
        //         'ans' => 'MouthPublicity.io is a mouth publicity media to increase your brand reach by sharing your business content on customer\'s WhatsApp. One can easily register their business on MouthPublicity.io and create and share their business offers with their customers through MouthPublicity.io.'
        //         ),
        //     array(
        //         'que' => 'What is an Instant Challenge?',
        //         'ans' => 'Instant Challenge is the fastest way to grow your social media presence. In an Instant Challenge, you need to provide customers with an instant benefit on their recent purchase and ask them to visit and follow your social media pages.'
        //     ),
        //     array(
        //         'que' => 'What is the Share Challenge?',
        //         'ans' => 'Share Challenge provides you with different features like Cash Per Click, Fixed Amount, Percentage Discount and it is the best way to grow your brand reach. In this, you need to provide customers a link via WhatsApp and ask them to share it in their network with some specified click target. Once the challenge is completed by the customer, you can offer them future benefits on the next purchase.'
        //     ),
        //     array(
        //         'que' => 'How is it better than digital marketing?',
        //         'ans' => 'MouthPublicity.io is the organic mouth publicity media marketing tool that runs on the idea of organically spreading the word for business through its customer and growing brand reach. MouthPublicity.io also offers a detailed analytical view of each penny invested and helps you in micro-level targeting of customers. Whereas Digital Marketing helps your market your business on a vast level.'
        //     ),
        //     array(
        //         'que' => 'Can your MouthPublicity.io Messaging API be integrated with any online billing software?',
        //         'ans' => 'Our MouthPublicity.io Messaging API can be integrated with the specific billing software that supports API integration.'
        //     ),
        //     array(
        //         'que' => 'How can I integrate MouthPublicity.io Messaging API with my POS system/billing software?',
        //         'ans' => 'Whenever you subscribe to MouthPublicity.io\'s Messaging API, a unique API Key will be generated which you can replace or integrate with the help of your POS/ Billing Software vendor.'
        //     ),
        //     array(
        //         'que' => 'Is my data safe with MouthPublicity.io?',
        //         'ans' => 'Yes, your data is safe with MouthPublicity.io. For more details click on <a href="'.url('privacy-policy').'">Privacy policy</a>.'
        //     ),
        //     array(
        //         'que' => 'I don\'t have a website, can I still use MouthPublicity.io?',
        //         'ans' => 'Yes, you can still use MouthPublicity.io and create offers by using customised templates.'
        //     ),
        //     array(
        //         'que' => 'I don\'t have social media pages, can I use MouthPublicity.io?',
        //         'ans' => 'Yes, you can use MouthPublicity.io to create offer content and promote it to your customer base on their WhatsApp.'
        //     ),
            
        //     array(
        //         'que' => 'Can I use MouthPublicity.io to increase my social media followers?',
        //         'ans' => 'A big Yes! With MouthPublicity.io, you can create instant challenges and share them with your customer and increase your social media followers.'
        //     ),
        //     array(
        //         'que' => 'Can I use my website URL to share my promotional offers?',
        //         'ans' => 'Yes, You can use your website URL for creating and promoting your business offer.'
        //     ),
        //     array(
        //         'que' => 'How do I get access to all your features of MouthPublicity.io?',
        //         'ans' => 'You can access all the features and products (with some limitations like challenge statistics, reports, customer name etc) of MouthPublicity.io for absolutely Free. To access MouthPublicity.io’s all features with full extent, simply you have to recharge with a minimum amount of 100 INR rupees. Refer <a href="'.url('pricing').'">pricing</a> here.'
        //     ),
        //     array(
        //         'que' => 'Is there any amount required to get registered on MouthPublicity.io?',
        //         'ans' => 'No, you can freely get registered just by details like your name, contact number, and email to register you with MouthPublicity.io.'
        //     ),
        //     array(
        //         'que' => 'How does your system prevent contestants from cheating the system?',
        //         'ans' => 'We have a track record of each click from the user and it is visible on the dashboard, while redeeming the offer he/she has to share their unique code which will be received on their number. Thus avoiding cheating from the system. For more details, you can check our privacy policy here.'
        //     ),
        //     array(
        //         'que' => 'How does an offer look on mobile?',
        //         'ans' => 'Mobile has been a priority to promote offers. Our templates are mobile-friendly which makes your offers look amazing on mobile! Each template is designed to be mobile-friendly.'
        //     ),
        //     array(
        //         'que' => 'Can MouthPublicity.io help me to get Twitter, Facebook, or LinkedIn followers?',
        //         'ans' => 'Yes! You can grow your social media followers by setting your campaign goal. You select Instant challenge and can ask your audience to like/follow your social media pages and offer them instant benefits.'
        //     ),
        //     array(
        //         'que' => 'Can I customise my offers?',
        //         'ans' => 'Yes, MouthPublicity.io allows  customization  for your offers. It has multiple pre-designed templates you can choose it according to your business needs and create attractive offers.'
        //     ),
        //     array(
        //         'que' => 'What if I am unable to open or access the link?',
        //         'ans' => 'The error in Opening a link or accessing it will only occur if there is an internet connectivity issue. Kindly check your network connectivity once, if you still face the issue please contact on the given number: <a href="tel:07887882244">07887882244</a>'
        //     ),
        //     array(
        //         'que' => 'How to Send Challenges on WhatsApp?',
        //         'ans' => 'Once you create a whole offer and save it then you are redirected to the next page with the subscribe button, click on it. You can share the link by adding a WhatsApp number.'
        //     ),
        //     array(
        //         'que' => 'How can I reset my Credentials?',
        //         'ans' => 'Click on the forget password, enter the registered email id or contact number, then you will receive a link on your registered email id and WhatsApp number, next reset the password, go to the link, reset the new password and you are all set to go with your new password.'
        //     ),
        //     array(
        //         'que' => 'How to track the clicks of subscribed customers?',
        //         'ans' => 'Go to MouthPublicity.io, click on the dashboard on the admin panel, Have a look at the clicks of all your customers right there on a single dashboard.'
        //     ),
        //     array(
        //         'que' => 'What are the benefits I would get after registration?',
        //         'ans' => 'Once you are registered with MouthPublicity.io, you can access all the products but with limitations., To get MouthPublicity.io\'s unlimited access with full extent, you can simply with your first recharge and use it on “pay as you go” basis. Refer <a href="'.url('pricing').'">pricing</a> here.'
        //     ),
        //     array(
        //         'que' => 'What is the validity of the link?',
        //         'ans' => 'There is no validity of the link. If the offer ends and the customer comes to avail of the benefit. You need to offer them some other benefits at that time.'
        //     ),
        //     array(
        //         'que' => 'How can I change the offer?',
        //         'ans' => 'Once the offer is active and the link is shared you cannot make changes to it.'
        //     ),
        //     array(
        //         'que' => 'Can I Use MouthPublicity.io to Promote offers?',
        //         'ans' => 'Yes definitely! You can use MouthPublicity.io to easily create and promote your business offers in your customer network.'
        //     ),
        //      array(
        //         'que' => 'How to change my shop location?',
        //         'ans' => 'Please go to settings and edit the address of your shop.'
        //     ),
        //      array(
        //         'que' => 'How to track the customer moves?',
        //         'ans' => 'You can analyse all analytics of your customer on the dashboard.'
        //     ),
        //     array(
        //         'que' => 'I don\'t use WhatsApp. Can I use MouthPublicity.io?',
        //         'ans' => 'MouthPublicity.io\'s all apps work through WhatsApp as its prominent feature is sharing the content. All the content sharing is carried out on WhatsApp so to use MouthPublicity.io one needs to have compulsory WhatsApp.'
        //     ),
        //     array(
        //         'que' => 'What is the benefit of social posts?',
        //         'ans' => 'You can use this for promotional purposes on social media.'
        //     ),
        //     array(
        //         'que' => 'Do I have to pay for a social post?',
        //         'ans' => 'This is free from MouthPublicity.io with the plan.'
        //     ),
        //     array(
        //         'que' => 'What is the use of the draft offer option?',
        //         'ans' => 'We can create the offer and draft it for future purposes.'
        //     ),
        //     array(
        //         'que' => 'What is meant by unique & Extra click?',
        //         'ans' => '<b>Unique Click</b> - If a person opens the offer link once.<br><b>Extra Click </b>- If a person opens the offer link more than once.'
        //     ),
        //     array(
        //         'que' => 'Why am I unable to see Today\'s clicks statistics?',
        //         'ans' => 'Statistics show present data on the next day or you can see the last 7 days data at a time.'
        //     ),
        //     array(
        //         'que' => 'Where Can I check my plan\'s expiry date?',
        //         'ans' => 'In the admin dashboard in the subscription option.'
        //     ),
        //     array(
        //         'que' => 'Can I add a video from YouTube to my offer?',
        //         'ans' => 'Yes, you can add video while creating an offer by using our offer template.'
        //     ),
        //     array(
        //         'que' => 'What is the use of the suspended option in the employee dashboard?',
        //         'ans' => 'For removing the employee from the employee list.'
        //     ),
        //     array(
        //         'que' => 'Whom should I approach in the case of an MouthPublicity.io product query?',
        //         'ans' => 'If you have any questions, just feel Personal to talk to us 24x7 i.e., anytime, from anywhere. Connect with us on <a href="mailto:care@mouthpublicity.io">care@mouthpublicity.io</a> or <a href="tel:07887882244">07887882244</a>.'
        //     ),
        //     array(
        //         'que' => 'Can MouthPublicity.io be used for any small-scale industry?',
        //         'ans' => 'Yes, You can use MouthPublicity.io for small as well as large-scale industries.'
        //     ),
        //     array(
        //         'que' => 'What is the use of an employee account?',
        //         'ans' => 'It provides a platform for multiple billing systems and employee details.'
        //     ),
        //     array(
        //         'que' => 'Can employees create an offer?',
        //         'ans' => 'No, the employee can share the offers but can not create offers.'
        //     ),
        //     array(
        //         'que' => 'Do employees need a WhatsApp Number to log in to an account?',
        //         'ans' => 'No, not required to be a WhatsApp user. but a WhatsApp number is mandatory to share the offers and posts.'
        //     ),
        // );
        @endphp
        
        
        {{-- List of all questions --}}
        <div class="">
            <div class="row justify-content-center align-items-center mt-5">
                <div class="col-xl-7 col-lg-8 col-12 px-0 px-sm-3">
                    <div class="accordion faq-accord" id="faq_accordian">
                        @php $i=0; @endphp
                        @foreach($faqs as $faq)
                        <div class="accordion-item">
                            <div class="accordion-header {{(!$i) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#faqs{{$i}}" aria-expanded="{{(!$i) ? 'true' : 'false' }}" aria-controls="faqs{{$i}}">
                                <h4 class="faq-que">{{$faq['que']}}</h4>
                            </div>
                            <div id="faqs{{$i}}" class="accordion-collapse collapse {{(!$i) ? 'show' : '' }}">
                                <div class="accordion-body">
                                    <p class="faq-ans">{!!$faq['ans']!!}</p>
                                </div>
                            </div>
                        </div>
                        @php $i++; @endphp
                        @endforeach
                    </div>
                </div> 
            </div> 
        </div>


    </div>

</section>
@endsection

@push('js')
    <script src="{{asset('assets/website/vendor/mark/dist/jquery.mark.js')}}"></script>
@endpush

@push('end_body')
<script>
    $(function() {

        /* 
        * Highlighting the search keyword in the question and answer using the plugin Markjs.
        * https://markjs.io/
        */ 
        $("#faq_search").on("input.highlight", function() {

            var keyword = $(this).val().toLowerCase();
            /* Highlight keywords */
            $(".faq-accord").unmark({
                done: function() {
                    $(".faq-accord").mark(keyword);
                }
            });
            /* Show hide question */
            $(".accordion-item").each(function(){
                var que = $(this).text();
                que = que.toLowerCase();
                if(que.includes(keyword)){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }).trigger("input.highlight").focus();

    });
</script>
@endpush