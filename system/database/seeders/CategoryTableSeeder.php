<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Option;
use App\Models\Category;
use App\Models\Categorymeta;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
			array('id' => '1','name' => 'Default','slug' => 'default','type' => 'parent_attribute','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38','user_id' => '1'),
			array('id' => '2','name' => 'COD','slug' => 'cod','type' => 'payment_gateway','p_id' => NULL,'featured' => '1','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38','user_id' => '1'),
			array('id' => '3','name' => 'INSTAMOJO','slug' => 'instamojo','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39','user_id' => '1'),
			array('id' => '4','name' => 'RAZORPAY','slug' => 'razorpay','type' => 'payment_gateway','p_id' => NULL,'featured' => '1','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39','user_id' => '1'),
			array('id' => '5','name' => 'PAYPAL','slug' => 'paypal','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-29 09:12:16','user_id' => '1'),
			array('id' => '6','name' => 'STRIPE','slug' => 'stripe','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40','user_id' => '1'),
			array('id' => '7','name' => 'TOYYIBPAY','slug' => 'toyyibpay','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40','user_id' => '1'),
			array('id' => '8','name' => 'Mollie','slug' => 'mollie','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:54:58','updated_at' => '2020-12-14 06:28:00','user_id' => '1'),
			array('id' => '9','name' => 'Paystack','slug' => 'paystack','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:54:58','updated_at' => '2020-12-14 06:28:00','user_id' => '1'),
			array('id' => '10','name' => 'Mercado','slug' => 'mercado','type' => 'payment_gateway','p_id' => NULL,'featured' => '0','menu_status' => '0','is_admin' => '0','created_at' => '2020-12-12 14:54:58','updated_at' => '2020-12-14 06:28:00','user_id' => '1'),
		);

    Category::insert($categories);


    $categorymetas = array(
						array('id' => '1','category_id' => '2','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38'),
						array('id' => '2','category_id' => '2','type' => 'preview','content' => 'uploads/cod.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '3','category_id' => '3','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '4','category_id' => '3','type' => 'preview','content' => 'uploads/instamojo.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '5','category_id' => '4','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '6','category_id' => '4','type' => 'preview','content' => 'uploads/razorpay.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '7','category_id' => '5','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '8','category_id' => '5','type' => 'preview','content' => 'uploads/paypal.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '9','category_id' => '6','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40'),
						array('id' => '10','category_id' => '6','type' => 'preview','content' => 'uploads/stripe.png','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40'),
						array('id' => '11','category_id' => '7','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40'),
						array('id' => '12','category_id' => '7','type' => 'preview','content' => 'uploads/toyyibpay.jpg','created_at' => '2020-12-12 14:49:40','updated_at' => '2020-12-12 14:49:40'),
						array('id' => '74','category_id' => '10','type' => 'preview','content' => 'uploads/mercado.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '75','category_id' => '10','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38'),
						array('id' => '42','category_id' => '8','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38'),
						array('id' => '49','category_id' => '8','type' => 'credentials','content' => '{"api_key":"","currency":"USD"}','created_at' => '2020-12-29 07:50:18','updated_at' => '2020-12-29 07:50:18'),
						array('id' => '43','category_id' => '8','type' => 'preview','content' => 'uploads/mollie.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),

						array('id' => '65','category_id' => '9','type' => 'credentials','content' => '{"public_key":"","secret_key":"","currency":"GHS"}','created_at' => '2020-12-29 07:50:18','updated_at' => '2020-12-29 07:50:18'),
						array('id' => '66','category_id' => '9','type' => 'preview','content' => 'uploads/paystack.png','created_at' => '2020-12-12 14:49:39','updated_at' => '2020-12-12 14:49:39'),
						array('id' => '67','category_id' => '9','type' => 'description','content' => 'description','created_at' => '2020-12-12 14:49:38','updated_at' => '2020-12-12 14:49:38'),

						array('id' => '45','category_id' => '3','type' => 'credentials','content' => '{"x_api_Key":"","x_api_token":""}','created_at' => '2020-12-29 07:42:54','updated_at' => '2020-12-29 07:42:54'),
		  				array('id' => '44','category_id' => '4','type' => 'credentials','content' => '{"key_id":"rzp_test_GCHoPl2cGGh7Oj","key_secret":"xEZJsrpzzhMnBRrzHFv8ksWh","currency":"USD"}','created_at' => '2020-12-29 07:42:37','updated_at' => '2020-12-29 07:51:10'),
		  				  array('id' => '46','category_id' => '5','type' => 'credentials','content' => '{"client_id":"","client_secret":"","currency":"USD"}','created_at' => '2020-12-29 07:43:08','updated_at' => '2020-12-29 09:01:49'),
						array('id' => '47','category_id' => '6','type' => 'credentials','content' => '{"publishable_key":"","secret_key":"","currency":"USD"}','created_at' => '2020-12-29 07:43:20','updated_at' => '2020-12-29 07:50:41'),
						array('id' => '48','category_id' => '7','type' => 'credentials','content' => '{"userSecretKey":"","categoryCode":""}','created_at' => '2020-12-29 07:43:32','updated_at' => '2020-12-29 07:43:32'),
					);

    	Categorymeta::insert($categorymetas);

    }
}




















