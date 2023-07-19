<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Option;
use App\Models\Adminmenu;
use App\Models\Plan;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::create([
    		'role_id' => 1,
    		'name' => 'Admin',
    		'mobile' => 9123456789,
    		'email' => 'admin@admin.com',
    		'password' => Hash::make('rootadmin'),
    	]);
    	
    	$roleAdmin = Role::create(['name' => 'Aadmin', 'role' => 'admin']);
    	$roleBussinessAdmin = Role::create(['name' => 'Business', 'role' => 'business']);
    	$roleEmployee = Role::create(['name' => 'Employee', 'role' => 'employee']);
    	
        $options =  array(
						array('id' => '1','key' => 'langlist','value' => '{"English":"en"}','created_at' => '2021-09-25 14:49:37','updated_at' => '2021-09-25 14:49:37'),
						array('id' => '2','key' => 'order_prefix','value' => 'AMC','created_at' => '2021-09-25 14:49:38','updated_at' => '2021-09-25 14:49:38'),
						array('id' => '3','key' => 'company_info','value' => '{"name":"Share","site_description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s","email1":"email@email.com","email2":"email2@email.com","phone1":"+8888888888","phone2":"+8888888888","country":"India","zip_code":"123456","state":"Maharashtra","city":"Nagpur","address":"IT Park","facebook":"#","twitter":"#","linkedin":"#","instagram":"#","youtube":"#","site_color":"#42155c"}','created_at' => '2021-09-25 14:49:38','updated_at' => '2021-09-25 07:30:52'),
						array('id' => '4','key' => 'currency_info','value' => '{"currency_name":"INR","currency_icon":"₹","currency_possition":"left"}','created_at' => '2021-09-25 14:49:38','updated_at' => '2021-09-25 14:49:38'),
						array('id' => '5','key' => 'cron_info','value' => '{"send_mail_to_will_expire_within_days":"7","send_notification_expired_date":"on","auto_assign_to_default":"on","auto_approve":"on"}','created_at' => '2021-09-25 14:49:38','updated_at' => '2021-09-25 14:49:38'),
						array('id' => '6','key' => 'header','value' => '{"title":"SHARE EVERYWHERE","highlight_title":"Increase your productivity","ytb_video":"75TGjNieK84","description":"Use one platform to share to anyone., anywhere\\u2014in online through your website, social media, and online marketplaces.","preview":"uploads\\/1\\/2021\\/01\\/1610213945.webp"}','created_at' => '2020-12-18 17:14:36','updated_at' => '2021-01-09 18:05:30'),
						array('id' => '7','key' => 'faqs','value' => '{"description":"<h2>Site Audit<\\/h2>\\r\\n\\r\\n<p>Site Audit crawls all the pages it finds on your website &ndash; then provides an overall SEO health score, visualises key data in charts, flags all possible SEO issues and provides recommendations on how to fix them.<\\/p>\\r\\n\\r\\n<p>Have a huge website? Not an issue.<\\/p>\\r\\n\\r\\n<p><a href=\\"https:\\/\\/demos.creative-tim.com\\/impact-design-system\\/front\\/pages\\/about.html\\">Learn More&nbsp;<\\/a><\\/p>","preview":"uploads\\/1\\/2020\\/12\\/1608311802.svg"}','created_at' => '2020-12-18 17:16:42','updated_at' => '2020-12-18 17:19:03'),
						array('id' => '8','key' => 'marketing_tool','value' => '{"ga_measurement_id":"UA-180680025-1","analytics_view_id":"231381168","google_status":"on","fb_pixel":"","fb_pixel_status":""}','created_at' => '2020-12-25 17:32:48','updated_at' => '2020-12-25 17:32:48'),
						array('id' => '9','key' => 'languages','value' => '{"en":"English","bn":"Bangla","ar":"Arabic"}','created_at' => '2021-01-05 09:51:31','updated_at' => '2021-01-11 17:07:34'),
						array('id' => '10','key' => 'active_languages','value' => '{"en":"English","ar":"Arabic"}','created_at' => '2021-01-08 15:21:41','updated_at' => '2021-01-11 17:07:52'),
						array('id' => '11','key' => 'about_1','value' => '{"title":"About Share","description":"Lorem Ipsum.","btn_link":"#priceing","btn_text":"Free Trial","preview":"icofont-cloud-upload"}','created_at' => '2021-01-09 18:51:25','updated_at' => '2021-01-16 06:22:49'),
						array('id' => '14','key' => 'seo','value' => '{"title":"Share","description":"test","canonical":"'.env('APP_URL').'","tags":"test","twitterTitle":"@share"}','created_at' => '2021-01-16 08:30:26','updated_at' => '2021-01-16 08:30:26'),
						array('id' => '15','key' => 'auto_order','value' => 'yes','created_at' => '2021-02-21 18:14:35','updated_at' => '2021-02-21 18:14:44'), 
						array('id' => '16','key' => 'ecom_features','value' => '{"top_image":"uploads\/1\/2021\/03\/1615392340.png","center_image":"uploads\/1\/2021\/03\/1615392340.webp","bottom_image":"uploads\/1\/2021\/03\/1615392340.webp","area_title":"Market your business","description":"Take the guesswork out of marketing with built-in tools that help you create, execute, and analyze digital marketing campaigns.","btn_link":"#service","btn_text":"Service"}','created_at' => '2021-02-21 18:14:35','updated_at' => '2021-02-21 18:14:44'),
						array('id' => '17','key' => 'counter_area','value' => '{"happy_customer":"1000","total_reviews":"800","total_domain":"1200","community_member":"2000"}','created_at' => '2021-02-21 18:14:35','updated_at' => '2021-02-21 18:14:44'),
					);

    	Option::insert($options);


        $adminmenus = array(
						array('id' => '1','name' => 'Header','position' => 'header','data' => '[{"text":"Home","href":"/","icon":"","target":"_self","title":""},{"text":"Pricing","href":"/priceing","icon":"empty","target":"_self","title":""},{"text":"Services","href":"/service","icon":"empty","target":"_self","title":""},{"text":"Contact","href":"/contact","icon":"empty","target":"_self","title":""},{"text":"Login","href":"/login","icon":"empty","target":"_self","title":""}]','status' => '1','created_at' => '2021-01-08 15:21:55','updated_at' => '2021-01-11 17:08:42'),
						array('id' => '2','name' => 'Useful links','position' => 'footer_left','data' => '[{"text":"Academy","href":"/","icon":"","target":"_self","title":""},{"text":"Help","href":"/contact","icon":"empty","target":"_self","title":""},{"text":"Community","href":"/contact","icon":"empty","target":"_self","title":""},{"text":"Tools","href":"/contact","icon":"empty","target":"_self","title":""}]','status' => '1','created_at' => '2021-01-10 08:46:43','updated_at' => '2021-01-16 07:04:06'),
						array('id' => '3','name' => 'Policy','position' => 'footer_right','data' => '[{"text":"Policy","href":"/page/terms-and-condition","icon":"empty","target":"_self","title":""},{"text":"Service Policy","href":"/page/terms-and-condition","icon":"empty","target":"_self","title":""},{"text":"Refund Policy","href":"/page/terms-and-condition","icon":"empty","target":"_self","title":""}]','status' => '1','created_at' => '2021-01-10 08:58:24','updated_at' => '2021-01-16 07:09:59'),
						array('id' => '4','name' => 'Information','position' => 'footer_center','data' => '[{"text":"About Us","href":"#about_us","icon":"empty","target":"_self","title":""},{"text":"Partners Program","href":"/contact","icon":"empty","target":"_self","title":""},{"text":"Priceing","href":"#priceing","icon":"empty","target":"_self","title":""},{"text":"Payment gateway","href":"/contact","icon":"empty","target":"_self","title":""}]','status' => '1','created_at' => '2021-01-10 08:58:40','updated_at' => '2021-01-16 07:02:47'),
					);

        Adminmenu::insert($adminmenus);
    

		$plans = array(
					array('id' => '1','name' => 'Basic','description' => 'Basic plan contains 1 offer limit.','price' => '100','days' => '365','offers_limit' => '1','status' => '1','featured' => '0','created_at' => '2021-09-25 14:51:30','updated_at' => '2021-01-16 07:27:51'),
					array('id' => '2','name' => 'Starter Business','description' => 'Basic plan contains 10 offer limit.','price' => '100','days' => '365','offers_limit' => '10','status' => '1','featured' => '0','created_at' => '2021-09-25 14:51:30','updated_at' => '2021-01-16 07:27:51'),
					array('id' => '3','name' => 'Enterprise','description' => 'Basic plan contains 100 offer limit.','price' => '100','days' => '365','offers_limit' => '100','status' => '1','featured' => '0','created_at' => '2021-09-25 14:51:30','updated_at' => '2021-01-16 07:27:51')
		);

    	Plan::insert($plans);


	}

}
