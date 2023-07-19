@extends('layouts.website')

@section('title', 'Privacy Policy | MouthPublicity.io')
@section('description', 'Our Privacy Policy outlines what data we collect, how we use it, and the rights you have to access, update or delete your information.')
{{-- @section('keywords', '') --}}
{{-- @section('image', '') --}}

@section('end_head')

@endsection

@section('content')
{{-- Policy Page --}}
<section id="policy">

    {{-- page heading --}}
    <div class="bg-light">
        <div class="container">
            {{-- Breadcrumb Section --}}
            @php
                $bcrm = array(
                    array('name' => 'Privacy Policy', 'link' => false),
                );
            @endphp
            @include('website.components.breadcrumb', $bcrm)
        </div>
        <div class="container">
            <div class="bumper">
                <div class="bm_inner pb-5">
                    <h1 class="font-800 color-gradient d-inline-block">Privacy Policy</h1>
                    {{-- <p class="mb-0"></p> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="py-5">
            <div class="content text-justify">
            
                <p><span class="font-600">MouthPublicity.io</span> ("MouthPublicity.io", "we" or "us") provides software that helps businesses (our "Customers") create and run engaging offers & campaigns that are promoted to their customers.</p>
                <p>We totally understand your concern regarding security & policy. We take it as an most important part of our platform. Therefore, this privacy policy tells how we take information from the user and maintain it and follow strong ethics when it comes to disclosing it to third parties. The policy is applied to all the product websites and services.</p>
                <p>In order to keep data safe, MouthPublicity.io has a strongly encrypted security system. This Privacy Policy applies to all users of our Site and Services.</p>
                <p>When you make an offer on the MouthPublicity.io site, you are completely responsible for activates of every kind that happens under your MouthPublicity.io account.You should not utilize your account deceptively or unlawfully, remembering for a way expected to exchange including data of others, and MouthPublicity.io may change content that it considers unseemly or unlawful, or in any case liable to cause MouthPublicity.io responsibility. </p>
                <p>You should quickly advise MouthPublicity.io's technical support centre of any unapproved of your content, your record, or some other breaks of safety.</p>
                <p>On the off chance that you make any future or instant offer - i.e customer of MouthPublicity.io use service and to construct an offer that your customer, workers, users, or different stakeholders take then,</p>


                <ul>
                    <li>Your offer experience reactions are claimed by you. While MouthPublicity.io might utilize analytics to acquire understanding into the utilization of our product, we don't sell or give the information to anybody without your authorization. </li>
                    <li>Your leads, and offer information are claimed by you. We don't utilize any of this information for ourselves or give it to outsiders. You must utilize this information.</li> 
                    <li>Your responses are possessed by the offer maker i.e. It is up to the offer experience maker how they utilize these responses. All reactions are unknown till you have given your user information.</li>
                </ul>


                <h4 class="font-700 text-capitalize color-primary h5">Content</h4>
                <p>You own the freedom to offer the content you post on MouthPublicity.io. We don't guarantee responsibility. Nonetheless, by presenting content on MouthPublicity.io, you allow us to utilize it, for nothing, to do the things we want to do to give MouthPublicity.io administrations which might incorporate putting away, showing, imitating, and circulating your content. By showing on MouthPublicity.io, you consent to permit others to see your offer.</p>
                <p>You are allowed to erase your content whenever. On the off chance that you erase your record or content, it could be unrecoverable.</p>

                <p><b>Here are a few things we restrict. By utilizing MouthPublicity.io, you vow not to do any of the accompanying things:</b></p>
                <ul>
                    <li>post any remarks, material, joins, text, pictures, sound, or video (any such material, "Content") containing any wrong data , virus, illegal information, worms, malware, Trojan ponies, or other unsafe or damaging content; </li>
                    <li>Post Content without consent from the owner; </li>
                    <li>Post Content that is explicit (pornographic), contains dangers, prompts viciousness, or disregards the freedoms of any outsider. </li>
                    <li>probe, output, or test our frameworks or organizations; </li>
                    <li>break or evade any advances we have set up for security or validation;</li>
                </ul>

                {{-- <h4 class="font-700 text-capitalize color-primary h5">fees, payments & cancellation policy</h4>
                <p>You consent to pay for the Services you use on the MouthPublicity.io Site in understanding the estimating and pricing terms introduced to you for that assistance. Expenses paid by you are non-refundable. </p>
                <p>For memberships, you will be charged ahead of time on a repetitive cycle for the period you have chosen (month to month or yearly,) toward the start of that period. Your membership will naturally restore toward the finish of every period.</p>
                <p>MouthPublicity.io might change the expenses charged for Services whenever, given that, for membership Services, the change will become compelling just upon the following recharging date.</p>

                <h4 class="font-700 text-capitalize color-primary h5">refund policy</h4>
                <p>We follow a reliable refund policy to let our customers feel privileged about their association with us. </p>
                <p>Please read the guidelines governing the refund policy.</p>
                <p>If you wish to cancel your account anytime, you will get a refund on MouthPublicity.io product package subscription on a usage (prorate) basis. For example, if you have subscribed for 1 month or 1 year subscription and used services for 15 days or 6 months, you will get a refund for the remaining 15 days or 6 months.</p>
                <p>If you have purchased message credits, they will not be refunded, but you can use the remaining message credits with your free MouthPublicity.io account. Any customization charges (if any) paid will not be refunded.</p>
                <p>Prorated refund will be calculated on monthly basis. If cancellation is requested on the 1st day of the subscription month, the full month will be considered for billing and service will be available to consume till the end of the billing month.</p>
                <p>Upon cancellation, your data will be completely deleted from our servers. Since deletion of all data is final please be sure that you download/export all data that you may want before requesting for cancellation.</p>
                <p><b>Note:</b> The refund amount will be calculated by excluding the GST ( which was paid by the customer at the time of purchase of MouthPublicity.io Product.)</p>

                <h4 class="font-700 text-capitalize color-primary h5">upgrades</h4>
                <p>An update is a point at which a paying client chooses to change their present plan to a more expensive paid plan. While updating a plan, you won't be given a discount for the current plan.</p>

                <h4 class="font-700 text-capitalize color-primary h5">downgrades</h4>
                <p>A downgrade is a point at which a paying client chooses to change their present plan to a less expensive paid plan. While updating a plan, you won't be given a discount for the current plan.</p> --}}

                <h4 class="font-700 text-capitalize color-primary h5">Fees, Payments, & Refund Policy</h4>
                <p>You consent to pay for the Services you use on the MouthPublicity.io Site in understanding the estimating and pricing terms introduced to you for that assistance. Expenses paid by you are non-refundable.</p>
                <p>Your pro access membership or subscription will naturally restore toward the recharge of minimum amount of Rs.100 and will naturally expired towards the nil balance of your mouthpublicity.io account.</p>
                <p>MouthPublicity.io might change the expenses charged for Services whenever, given that, for membership Services, the change will become compelling just upon the following recharging date.</p>

                

                <h4 class="font-700 text-capitalize color-primary h5">things that we forbid</h4>
                <p><b>Here are a few things we disallow.</b></p>
                <p>By utilizing MouthPublicity.io, you vow not to do any of the accompanying things; posting any useless comments links, joins, text, pictures, sound, or video (any such material, "Content") containing any viruses, Trojan ponies, or other hurtful or ruinous substance; posting Content without authorization from the proprietor; posting explicit Content, contains dangers, prompts brutality, or abuses the freedoms of any outsider; test, sweep, or test our frameworks or organizations.</p>

                <h4 class="font-700 text-capitalize color-primary h5">data deletion policy</h4>
                <ol>
                    <li><p><b>Individual Rights</b></p>
                        <p>An individual has the option to demand the request for erasure or expulsion of individual information where there is no convincing justification for keeping information.</p>
                    </li>
                    <li>
                        <p><b>When does the right to deletion apply?</b></p>
                        <ul>
                            <li>People reserve a privilege to have individual information deleted when it is of no use anymore.  </li>
                            <li>Where the individual information is as of now excessive use to the reason for which it was initially gathered/handled; </li>
                            <li>When the individual information was unlawfully handled; </li>
                            <li>Where the individual information must be eradicated to conform to a lawful commitment.</li>
                        </ul>
                    </li>
                    <li>
                        <p><b>How can data be deleted?</b></p>
                        <p>You can erase any of your MouthPublicity.io information anytime, by going to MouthPublicity.io user account signing into your record, and afterward clicking client details, and there you can pick which customer data you might want to erase. This will permit you to erase the information straightforwardly from your record.</p>
                        <p>A few information might in any case stay in the framework's backup documents, which will be erased intermittently.</p>
                        <p>If you contact us for an information deletation demand, we attempt to play out the erasure inside 15 workdays and will send you a notification once the data has been erased. At every possible opportunity, we will intend to complete your request as earliest as possible.</p>
                    </li>
                </ol>

                <h4 class="font-700 text-capitalize color-primary h5">privacy</h4>
                <p>You agree to the exchange, store, and handling of your data - including however not restricted to the content you presented or moved on the site and any personal information</p>
                <p>The kind of data that MouthPublicity.io assembles relies upon the idea of communication.  MouthPublicity.io doesn't open up expressly personal data other than as portrayed way described below.</p>
                <p>Aggregated Statistics MouthPublicity.io may collect statistics about the behaviour of visitors to its websites. </p>
                <p>Protection of Certain Personally-Identifying Information MouthPublicity.io open ups its data just to those of its workers, that</p>
                <ul>
                    <li>need to work on that data on behalf of MouthPublicity.io or provide service at the MouthPublicity.ioS website.</li>
                    <li>That have agreed not to disclose information</li>
                </ul>

                <p>MouthPublicity.io won't lease or sell possibly personal data to anybody. </p>
                <p>In case you are a listed client of an MouthPublicity.io and have provided your email address, MouthPublicity.io may every so often send you an email to inform you concerning new features, request your input, or simply stay up with the latest with what's new with MouthPublicity.io and our items.</p>
                <p>We principally utilize our different BLOGS to impart this sort of data, so we hope to keep you updated with this kind of data on email. </p>
                <p>On the off chance that you send us a request, we reserve the right to publish it on our website to help others with that same query</p>


            </div>
        </div>
    </div>

</section>
@endsection

{{-- @push('end_body')

@endpush --}}