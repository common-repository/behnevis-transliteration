<?php

	/*
	Plugin Name: Behnevis Transliteration
	Plugin URI: http://www.moallemi.ir/blog/1388/07/25/%d8%a7%d9%81%d8%b2%d9%88%d9%86%d9%87-%d9%86%d9%88%db%8c%d8%b3%d9%87-%da%af%d8%b1%d8%af%d8%a7%d9%86-%d8%a8%d9%87%d9%86%d9%88%db%8c%d8%b3-%d8%a8%d8%b1%d8%a7%db%8c-%d9%88%d8%b1%d8%af%d9%be%d8%b1%d8%b3/
	Description: Behnevis Persian Transliteration support for wordpress.
	Version: 0.5
	Author: Reza Moallemi
	Author URI: http://www.moallemi.ir/blog
	*/
	
	add_action('admin_menu', 'b_trans_menu');

	function b_trans_menu() 
	{
		add_options_page('Behnevis Transliteration Options', 'نویسه گردان بهنویس' , 8, 'behnevis-transliteration', 'b_trans_options');
	}

	function get_b_trans_options()
	{
		$b_trans_options = array('enable_comment_form' => 'true',
								'comment_form_id' => 'comment',
								'comment_form_text' => 'پس از نوشتن متن بر روی تصویر سمت راست کلیک کنید تا کلمات فینگلیش به فارسی تبدیل شوند.');
		$g_trans_save_options = get_option('b_trans_options');
		if (!empty($g_trans_save_options))
		{
			foreach ($g_trans_save_options as $key => $option)
			$b_trans_options[$key] = $option;
		}
		update_option('b_trans_options', $b_trans_options);
		return $b_trans_options;
	}
	
	function behnevis_comment_form()
    {
		$b_trans_options = get_b_trans_options();
		?>
		<div style="display:left;align:left; padding-top:7px;" id='behnevisTranslControl'>
		<small>
			<a href="#" onclick="return behnevis.launchPopup(this, '<?php echo $b_trans_options['comment_form_id']; ?>');">
				<img src="<?php echo get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));?>/behnevis_enable_green.gif" alt="" style="border:none" />
			</a>
			<?php echo $b_trans_options['comment_form_text']; ?>
		</small>
		</div>
		<div id="errorDiv"></div>
		<script language="JavaScript" type="text/javascript">
			var urlp;            
			var mozilla = document.getElementById && !document.all;			
            var url = document.getElementById("url");
			if (mozilla)
	            urlp = url.parentNode;
			else
				    urlp = url.parentElement;
            var sub = document.getElementById("behnevisTranslControl");
            urlp.appendChild(sub, url);
        </script>	
		<?php
	}
	
	function behnevis_post_form()
    {
		?>
		<div style="display:left;align:left; padding-top:7px;" id='behnevisTranslControl'>
		<small>(To type in English, press Ctrl+g)</small>
		</div>
		<div id="errorDiv"></div>
		<script language="JavaScript" type="text/javascript">
			var urlp;            
			var mozilla = document.getElementById && !document.all;			
            var url = document.getElementById("quicktags");
			if (mozilla)
	            urlp = url.parentNode;
			else
				    urlp = url.parentElement;
            var sub = document.getElementById("behnevisTranslControl");
            urlp.appendChild(sub, url);
        </script>	
		<?php
	}
	
	function behnevis_wp_post_admin_scripts()
	{
		$b_trans_options = get_b_trans_options();
		?>		
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<?php
	}
	
	function BehnevisTransliteration() 
	{
		add_action('wp_head', 'behnevis_wp_head_scripts');
		add_action('comment_form', 'behnevis_comment_form');
	}

	function b_trans_options()
	{
		$b_trans_options = get_b_trans_options();
		if (isset($_POST['update_b_trans_settings']))
		{
			$b_trans_options['default_language'] = isset($_POST['default_language']) ? $_POST['default_language'] : 'fa';
			$b_trans_options['enable_comment_form'] = isset($_POST['enable_comment_form']) ? $_POST['enable_comment_form'] : 'false';
			$b_trans_options['comment_form_id'] = (isset($_POST['comment_form_id']) and $_POST['comment_form_id'] != '') ? $_POST['comment_form_id'] : 'comment';
			$b_trans_options['comment_form_text'] = (isset($_POST['comment_form_text']) and  $_POST['comment_form_text'] != '' )? $_POST['comment_form_text'] : 'پس از نوشتن متن بر روی تصویر سمت راست کلیک کنید تا کلمات فینگلیش به فارسی تبدیل شوند.';

			update_option('b_trans_options', $b_trans_options);
			?>
			<div class="updated">
				<p><strong>تنظیمات ذخیره شد.</strong></p>
			</div>
			<?php
		} ?>
		<div class=wrap>
			<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<h2>تنظیمات نویسه گردان بهنویس</h2>
				<h3>تنظیمات دیدگاه ها:</h3>
				<p><input name="enable_comment_form" value="true" type="checkbox" <?php if ($b_trans_options['enable_comment_form'] == 'true' ) echo ' checked="checked" '; ?> /> فعال کردن برای فرم دیدگاه ها.</p>
				<p>شناسه ی فیلد متن دیدگاه: 
					<input name="comment_form_id" style="direction:ltr;" type="text" value="<?php echo $b_trans_options['comment_form_id']; ?>" /> 
					<small>شناسه ی پیش فرض در پوشته های وردپرس <b>comment</b> می باشد.</small>
				</p>
				<p>
					توضیح: <input type="text" name="comment_form_text" style="width:550px;" value="<?php echo $b_trans_options['comment_form_text'];?>" />
				</p>
				<div class="submit">
					<input type="submit" name="update_b_trans_settings" value="ذخیره تغییرات" />
				</div>
				<hr />
				<div>
					<h4>دیگر افزونه های من برای وردپرس:</h4>
					<ul>
						<li>- <b>نویسه گردان گوگل</b> (<a href="http://wordpress.org/extend/plugins/google-transliteration/">دریافت</a> | <a href="http://www.moallemi.ir/blog/1388/07/19/%d8%a7%d9%81%d8%b2%d9%88%d9%86%d9%87-%db%8c-%d9%86%d9%88%db%8c%d8%b3%d9%87-%da%af%d8%b1%d8%af%d8%a7%d9%86-%da%af%d9%88%da%af%d9%84-%d8%a8%d8%b1%d8%a7%db%8c-%d9%88%d8%b1%d8%af%d9%be%d8%b1%d8%b3/">اطلاعات بیشتر</a>)</li>
						<li>- <b>نمایش دهنده ی اطلاعات نظر دهندگان</b> (<a href="http://wordpress.org/extend/plugins/advanced-user-agent-displayer/">دریافت</a> | <a href="http://www.moallemi.ir/blog/1388/07/24/%D8%A7%D9%81%D8%B2%D9%88%D9%86%D9%87-%DB%8C-%D9%86%D9%85%D8%A7%DB%8C%D8%B4-%D8%AF%D9%87%D9%86%D8%AF%D9%87-%DB%8C-%D8%A7%D8%B7%D9%84%D8%A7%D8%B9%D8%A7%D8%AA-%D9%86%D8%B8%D8%B1-%D8%AF%D9%87%D9%86%D8%AF/">اطلاعات بیشتر</a> )</li>
					</ul>
				</div>
			</form>
		</div>
		<?php
	}
							
	function behnevis_wp_head_scripts()
	{	
		$b_trans_options = get_b_trans_options();
		if ((is_single() || is_page()) and $b_trans_options['enable_comment_form'] == 'true') 
		{
			?>		
			<script type="text/javascript" src=" http://behnevis.s3.amazonaws.com/behnevisapi.js"></script>
			<?php
		}
	}
	
	BehnevisTransliteration();
		
?>
