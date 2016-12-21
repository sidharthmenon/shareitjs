<?php 
    /*
    Plugin Name: shareIt.js – Social Content Locker jQuery Plugin 
    Plugin URI: https://github.com/sidharthmenon/shareitjs
    Description: shareIt.js is a jQuery Social Content Locker Plugin. With shareIt, you can lock anything in your content and the content will be automatically unlocked when user share it on Social Media.
    Author: Sidharth Menon
    Version: 1.0
    Author URI: http://www.sidharthmenon.com
    
    Based on shareIt.js made by Shubham Kumar - My Coding Tricks
    http://mycodingtricks.com/jquery/shareit-js-social-content-unlocker/s
    
    */
    
    function shareit_add_header_items()
    {
        echo '<script type="text/javascript" src="assets/js/shareIt.js"></script>';
        echo '<link href="assets/css/shareIt.css" rel="stylesheet"/>';
        
            $disp_title = get_option('shareit_disp_title');
            $disp_text = get_option('shareit_disp_text');
            $fb_page = get_option('shareit_fb_page');
            $fb_appid = get_option('shareit_fb_appid');
            $twit_name = get_option('shareit_twit_name');
            $g_apikey = get_option('shareit_g_apikey');
            $g_ana = get_option('shareit_g_ana');
        
        echo <<<EEE
            <script>
                var options = {
                    title: "$disp_title", //Heading of Content Locker
                    text: '$disp_text', //Subheading of Content Locker
                    facebook:{
                        url: window.location.href,  //Your Content Page Url
                        pageId: "$fb_page",  //Your Facebook Page Url
                        appId: $fb_appid  //Your Facebook App ID
                    },
                    twitter:{
                        via: '$twit_name', //Twitter Username
                        url: window.location.href,
                        text: document.title
                    },
                    googleplus:{
                        apikey: '$g_apikey', //Google App API key
                        url: window.location.href,
                    },
                    linkedIn:{
                        url: window.location.href
                    },
                    buttons:["facebook_share","twitter_tweet","googleplus","twitter_follow","facebook_like","linkedin"],
 
/*
* To Enable Cookies 
*/
                   id: 5, //Give it a Unique id. It could be anything like digits.
                   cookie: true, //Cookie is Enabled
                   cookieExpiry: 10 //Cookie Will Expire in 10 Days
                };
 
            $(".lock").shareIt(options);
        </script>
        <script>
        var _gaq = _gaq || [];
_gaq.push(['_setAccount', '$g_ana']);
_gaq.push(['_trackPageview']);
 
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
        </script>
EEE;
    }
    
    function shareit_add_admin_menu()
    {
        add_options_page( "Shareit - Social Locker", "Shareit - Social Locker", 1, "Shareit - Social Locker", shareit_admin_page);
    }
    
    function shareit_admin_page()
    {
        if(isset($_POST['submit']))
        {
            
            $disp_title = $_POST['disp_title'];
            update_option('shareit_disp_title',$disp_title);
            
            $disp_text = $_POST['disp_text'];
            update_option('shareit_disp_text',$disp_text);
            
            $fb_page = $_POST['fb_page'];
            update_option('shareit_fb_page', $fb_page);
            
            $fb_appid = $_POST['fb_appid'];
            update_option('shareit_fb_appid', $fb_appid);
            
            $twit_name = $_POST['twit_name'];
            update_option('shareit_twit_name', $twit_name);
            
            $g_apikey = $_POST['g_apikey'];
            update_option('shareit_g_apikey', $g_apikey);
            
            $g_ana = $_POST['g_ana'];
            update_option('shareit_g_ana', $g_ana);
            
            ?>
            <div class="updated"><p><strong>Options Saved</strong></p></div>
            <?php
        }
        else{
            $disp_title = get_option('shareit_disp_title');
            $disp_text = get_option('shareit_disp_text');
            $fb_page = get_option('shareit_fb_page');
            $fb_appid = get_option('shareit_fb_appid');
            $twit_name = get_option('shareit_twit_name');
            $g_apikey = get_option('shareit_g_apikey');
            $g_ana = get_option('shareit_g_ana');
            ?>
            <div class="wrap">
                <h3>Shareit.js Settings</h3>
                <form name="shareit_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <h4>General Settings</h4>
                    <p>Display Title : <input type="text" name="disp_title" value="<?php echo $disp_title ?>"></p>
                    <p>Display Text : <input type="text" name="disp_text" value="<?php echo $disp_text ?>"></p>
                    <hr/>
                    <h4>Facebook Settings</h4>
                    <p>Facebook Page : <input type="text" name="fb_page" value="<?php echo $fb_page ?>"></p>
                    <p>Facebook App Id : <input type="text" name="fb_appid" value="<?php echo $fb_appid ?>"></p>
                    <hr/>
                    <h4>Twitter Settings</h4>
                    <p>Twitter Username : <input type="text" name="twit_name" value="<?php echo $twit_name ?>"></p>
                    <hr/>
                    <h4>Google Settings</h4>
                    <p>Google API Key : <input type="text" name="g_apikey" value="<?php echo $g_apikey ?>"></p>
                    <p>Google Analytics : <input type="text" name="g_ana" value="<?php echo $g_ana ?>"></p>
                    <p class="submit">
                        <input type="submit" name="submit" value="Update Options" />
                    </p>
                </form>
            </div>
            <?php
        }
    }
    
    function shareit_shortcode($atts, $content= null)
    {
        echo '<div class="lock mct_shareit_locker">'.$content.'</div>'
    }
    
    add_action('wp_footer','shareit_add_header_items');
    add_action('admin_menu', 'shareit_add_admin_menu');
    add_shortcode('shareit_locker', shareit_shortcode);
    
?>