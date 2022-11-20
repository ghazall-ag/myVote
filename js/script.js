(function($){
	
	$('.vote1').click(function(){
		
		if (myvote.user_id!=0)
		{
			
		var my_img=this;
		var post_id=$(my_img).attr('href').replace('#','');
		
		$('.vote-'+post_id).html(myvote.waiting);
		
		
		var data={
			
			action:'send_vote',
			post_id:post_id,
			vote:1
		
		};
		
		$.get(myvote.ajaxurl,data,function(data){
			
			$('.vote-'+post_id).after(myvote.thanks).remove();
			
			
		}
		
		);
		
		
		
		}
		else
		{
			alert(myvote.only_users);
		}
		
		
		return false;
		
		
	}
	
	);
	
	
	
	
	
	
	
	
	
	
	
	
	
		$('.vote2').click(function(){
		
		if (myvote.user_id!=0)
		{
			
		var my_img=this;
		var post_id=$(my_img).attr('href').replace('#','');
		
		$('.vote-'+post_id).html(myvote.waiting);
		
		
		var data={
			
			action:'send_vote',
			post_id:post_id,
			vote:2
		
		};
		
		$.get(myvote.ajaxurl,data,function(data){
			
			$('.vote-'+post_id).after(myvote.thanks).remove();
			
			
		}
		
		);
		
		
		
		}
		else
		{
			alert(myvote.only_users);
		}
		
		
		return false;
		
		
	}
	
	);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$('.vote3').click(function(){
		
		if (myvote.user_id!=0)
		{
			
		var my_img=this;
		var post_id=$(my_img).attr('href').replace('#','');
		
		$('.vote-'+post_id).html(myvote.waiting);
		
		
		var data={
			
			action:'send_vote',
			post_id:post_id,
			vote:3
		
		};
		
		$.get(myvote.ajaxurl,data,function(data){
			
		$('.vote-'+post_id).after(myvote.thanks).remove();
			
			
		}
		
		);
		
		
		
		}
		else
		{
			alert(myvote.only_users);
		}
		
		
		return false;
		
		
	}
	
	);
	
	
	
	
	
}

)(jQuery)