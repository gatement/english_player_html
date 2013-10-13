function fetchSoundUrl()
{
	$.ajax("/fetchSoundUrl.php", {
		timeout: 20000,
		success: function(data){
		    if(data.soundUrl)
		    {
		    	play(data.soundUrl);
		    	$("#articleLink").attr("href", data.articleUrl);
		    }
		    else
		    {
		    	fetchSoundUrl();
		    }
		  },
		error: function(){
			fetchSoundUrl();
		  }
	});
}

function play(url)
{
	$("#jquery_jplayer_1").jPlayer("setMedia", {
	     mp3: url
	   }).jPlayer("play");
}

$(document).ready(function() {
	$("#jquery_jplayer_1").jPlayer({
        ready: function () {
        	fetchSoundUrl();
        },
        ended: function()
        {
        	if($("#jquery_jplayer_1").jPlayer("option","loop") == false)
        	{
        		fetchSoundUrl();
        	}
        },
        swfPath: "/swf/jplayer",
        supplied: "mp3"
      });
});


