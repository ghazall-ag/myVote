<?php
/*
Plugin Name: MyVote
Version: 1.1
Author:ghazall-agoush@yahoo.com
Description: نظر سنجي از کاربران
License: GPLv2





add_action('plugins_loaded','add_textdomain');

function add_textdomain()
{
	
	load_plugin_textdomain('my-vote',false,dirname(plugin_basename(__FILE__)));
	
}


add_action('admin_menu','add_menu');

function add_menu()
{
	
	add_menu_page(__('Vote result','my-vote'),__('Vote result','my-vote'),'manage_options','my_vote_options','my_vote_options',plugins_url('my-vote/images/icon.png'));
	
}

function my_vote_options()
{
global $wpdb;

$vote1=$wpdb->get_var("select count(*) from $wpdb->postmeta where meta_key like 'vote-%' and meta_value=1");
$vote2=$wpdb->get_var("select count(*) from $wpdb->postmeta where meta_key like 'vote-%' and meta_value=2");
$vote3=$wpdb->get_var("select count(*) from $wpdb->postmeta where meta_key like 'vote-%' and meta_value=3");

echo "<br/><br/>".__('Vote','my-vote')." 1 = ".$vote1."<br/><br/>";

echo __('Vote','my-vote')." 2 = ".$vote2."<br/><br/>";

echo __('Vote','my-vote')." 3 = ".$vote3."<br/><br/><br/><br/>";

?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container"></div>


<script>

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Vote result'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
		{
            name: 'Vote1',
            y: <?php echo $vote1;  ?>
        },
		{
            name: 'Vote2',
            y: <?php echo $vote2;  ?>
        },
		{
            name: 'Vote3',
            y: <?php echo $vote3;  ?>
        }
		
		
		]
    }]
});

</script>


<?php
	
}


add_filter('the_content','the_content_func');

function the_content_func($content)
{
	
	if (!$vote_meta = get_post_meta(get_the_ID(),'vote-'.get_current_user_id(),true))
	{
	
	$content.="<p  class='vote-".get_the_ID()."'>";
	
	$content.="<a href='#".get_the_ID()."' class='vote1'><img src='".plugin_dir_url(__FILE__).'images/1.png'."' width='50px'></a>'";
	
	$content.="<a href='#".get_the_ID()."' class='vote2'><img src='".plugin_dir_url(__FILE__).'images/2.png'."'  width='50px'></a>'";
	
	$content.="<a href='#".get_the_ID()."' class='vote3'><img src='".plugin_dir_url(__FILE__).'images/3.png'."'  width='50px'></a>'";
	
	$content.="</p>";
	}
	else
	{
		
		$content.="<p>";
		
		$content.=__('Your vote','my-vote')." : <img src='".plugin_dir_url(__FILE__).'images/'.$vote_meta.".png' width='50px' >";
		
		$content.="</p>";
		
	}
	
	
	return $content;
}

add_action('init','add_js');

function add_js(){
	
	
	wp_enqueue_script('myvote',plugin_dir_url(__FILE__).'js/script.js',array('jquery'),'1.0',true);
	
	$params=array(
	
		'ajaxurl'=>admin_url('admin-ajax.php'),
		'user_id'=>get_current_user_id(),
		'waiting'=>__('please wait...','my-vote'),
		'only_users'=>__('only users can vote .','my-vote'),
		'thanks'=>__('thank you for your vote .','my-vote')
		
	);
	
	wp_localize_script('myvote','myvote',$params);


}



add_action('wp_ajax_send_vote','send_vote');
add_action('wp_ajax_nopriv_send_vote','send_vote');


function send_vote()
{
	
	$post_id=$_REQUEST['post_id'];
	$vote = $_REQUEST['vote'];
	
	
		update_post_meta($post_id,'vote-'.get_current_user_id(),$vote);
	
	
	die();
	
	
}


add_action('wp_dashboard_setup','my_widget');

function my_widget()
{
	
	wp_add_dashboard_widget('my_widget_plugin',__('Latest votes','my-vote'),'my_widget_display');
	
}

function my_widget_display()
{
	
	global $wpdb;

	$latest_votes=$wpdb->get_results("select * from $wpdb->posts,$wpdb->postmeta where $wpdb->postmeta.meta_key like 'vote-%' and $wpdb->postmeta.post_id = $wpdb->posts.id  order by $wpdb->postmeta.meta_id desc limit 10");
		
		 $output="";
		
		
		if ($latest_votes)
		{
			
		     foreach ($latest_votes as $post) {
           
                $post_title = get_the_title($post);
               
			   $user_name = $wpdb->get_var( "SELECT user_nicename FROM $wpdb->users where ID=".str_replace('vote-','',$post->meta_key) );
              
                $output .= "<a href='".get_permalink($post)."'>".$post_title."</a><br/>(user : ".$user_name." - ".__( 'Vote', 'my-vote' ).": $post->meta_value ) <br/><br/>";
            }
			
			
		}else
		{
			$output.=__('N/A','my-vote');
		}
		
		
		
		
		
		
		echo $output;
	
	
	
	
}




?>