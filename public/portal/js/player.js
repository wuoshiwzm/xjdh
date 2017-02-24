
	$(document).ready(function() {	
			  var player;
			 // flowplayer("player", "/public/flowplayer/flowplayerhls.swf");
			  $('.image').fancybox();
			  $('.video').fancybox({
			    tpl: {
			      // wrap template with custom inner DIV: the empty player container
			      wrap: '<div class="fancybox-wrap"  tabIndex="-1">' +
			            '<div class="fancybox-skin">' +
			            '<div class="fancybox-outer">' +
			            '<div id="player">' + // player container replaces fancybox-inner
			            '</div></div></div></div>' 
			    },
			    keys: {
			      // disable fancybox slideshow toggle
			      play: null
			    },

			    beforeShow: function () {
			      var base = this.href.slice(1),
			          //cdn = "//edge.flowplayer.org/";
			          cdn = "http://" + window.location.host + "/public/portal/Station_image/";
			      // install player into empty container
			      player = flowplayer("#player",{
			        splash: true,    // to properly unload the player on shutdown
			        ratio: 9/16,
			        qualities: "216p,360p,720p,1080p",
			        defaultQuality: "360p",
			        rtmp: "rtmp://s3b78u0kbtx79q.cloudfront.net/cfx/st",
			        clip: {
			          autoplay: true,
			          sources: [
			            //{ type: "application/x-mpegurl", src: cdn + base + ".m3u8" },
			            
			            { type: "video/flash/",           src: cdn+ base }
			          ]
			        }
			      }).load();
			     
			    },
			    beforeClose: function () {
			      // important! shut down the player as fancybox removes container
			      player.shutdown();
			    }
			  });

			  
			  
			  
			  
			  
			  
			  
			  
			  
			  
			});
