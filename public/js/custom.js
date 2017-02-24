Array.prototype.indexOf = function(e) {
	for (var i = 0, j; j = this[i]; i++) {
		if (j == e) {
			return i;
		}
	}
	return -1;
}

//对Date的扩展，将 Date 转化为指定格式的String
//月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符， 
//年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字) 
//例子： 
//(new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423 
//(new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18 
Date.prototype.Format = function (fmt) {
	var o = {
	   "M+": this.getMonth() + 1, //月份 
	   "d+": this.getDate(), //日 
	   "h+": this.getHours(), //小时 
	   "m+": this.getMinutes(), //分 
	   "s+": this.getSeconds(), //秒 
	   "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
	   "S": this.getMilliseconds() //毫秒 
	};
	if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	for (var k in o)
	if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
	return fmt;
}

function initstyle()
{
	if(isMobile)
	{
		document.getElementsByClassName('leftbar')[0].style='width:260px;';
		document.getElementsByClassName('main-wrapper')[0].style='margin-left:260px;';
	}
}
$(function(){
/*================================
	SELECT
=================================*/

	$(".chzn-select.chzn-search-disabled").chosen({disable_search:true});
	$(".chzn-select").chosen();

/*================================
	SCROLL TOP
=================================*/

    $(".scroll-top").hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scroll-top').fadeIn();
        } else {
            $('.scroll-top').fadeOut();
        }
    });

    $('.scroll-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });


/*================================
	LEFT BAR TAB
=================================*/
	if(isMobile){
    	$($('#myTab li.active>a').attr('href')).addClass("active");
	}
	$($(this).attr('href')).addClass("active");
	var activeTab = null;
	$('#myTab a').click(function (e) {
        e.preventDefault();
        if (isMobile) {
            $(this).tab('show');
        }else{
        	if(activeTab != null && activeTab[0] == $(this)[0])
        	{
            	activeTab = null;
            	$(this).parent().removeClass("active");
            	var selector = $(this).attr('href');
            	$(selector).removeClass("active");
            	
            	$(".leftbar").css('width','50px');
                $(".main-wrapper").css('margin-left','50px');
            	return;
        	}
            $(".leftbar").css('width','260px');
            $(".main-wrapper").css('margin-left','260px');
            activeTab = $(this);
            $(this).tab('show');
    		var selector = $(this).attr('href');
	       	$(selector).addClass("active");
        }
        
    });
	
	$('.left-primary-nav li a').tooltip({
        placement: 'right'
    });
	$('.row-action .btn').tooltip({
        placement: 'top'
    });


/*================================
	TOP TOOLBAR TOOL TIP
=================================*/
    $('.top-right-toolbar a').tooltip({
        placement: "top"
    });


/*================================
	SYNTAX HIGHLIGHTER
=================================*/
// make code pretty
window.prettyPrint && prettyPrint()


/*================================
RESPONSIVE NAV $ THEME SELECTOR
=================================*/

	$('.responsive-leftbar').click(function()
	{
		$('.leftbar').toggleClass('leftbar-close expand',500, 'easeOutExpo');
	});

	$('.theme-setting').click(function()
	{
		$('.theme-slector').toggleClass('theme-slector-close theme-slector-open',500, 'easeOutExpo');
	});


	$('.theme-color').click(function()
	{
		var stylesheet = $(this).attr('title').toLowerCase();
		$('#themes').attr('href','css'+'/'+stylesheet+'.css');
	});		
	$('.theme-default').click(function(){
		$('#themes').removeAttr("href");
	});
			

/*================================
	SEARCH
=================================*/
	$("#stationKeyword").autocomplete({
        source: function( request, response ) {
          $.ajax( {
            url: "/portal/search_station",
            dataType: "jsonp",
            data: {
              keyword : request.term
            },
            success: function( data ) {
              response( data );
            }
          } );
        },
        minLength: 2
      }).keypress(function(e){
		var e = e || event,
		keycode = e.which || e.keyCode;
		if (keycode==13) {
			$("#btn-search").trigger("click");
		}
	});
	$('#btn-search').click(function(){
		if($('#stationKeyword').val().length > 0)
		{
			window.location.href = '/portal/search?q=' + encodeURIComponent($('#stationKeyword').val());
		}
	});

/*================================
	TABLE SORTER
=================================*/
	$('.table-sortable').tablesorter();

/*================================
	POPEROVER
=================================*/
	$('[rel="popover"],[data-rel="popover"]').popover();

/*================================
	city county substation room 
=================================*/
	$('.widget-head').click(function(){
		$(this).next('.widget-container').slideToggle();
	});
	$('#selCity').change(function(){
		$.get('/portal/getcounty',{citycode:$(this).val()},function(data){
			eval('var ret =' + data);
			$('#selCounty').empty();
			$('#selCounty').append('<option value="">所有分局</option>' );
			if(ret.ret == 0){
				for(i = 0 ; i < ret.countyList.length ; i++)
				{
					var countyObj = ret.countyList[i];
					$('#selCounty').append('<option value="'+countyObj.key +'">'+countyObj.val +'</option>' );
				}
			}
			$('#selCounty').trigger("liszt:updated");
			$('#selCounty').trigger("change");
		});
	});
	
	$('#manufacturers').change(function(){
		$.get('/portal/getversion',{manufacturers:$(this).val()},function(data){
			eval('var ret =' + data);
			$('#version').empty();
			$('#version').append('<option value="">--默认为空--</option>' );
			if(ret.ret == 0){
				for(i = 0 ; i < ret.versionList.length ; i++)
				{
					var versionObj = ret.versionList[i];
					$('#version').append('<option value="'+versionObj.key +'">'+versionObj.val +'</option>' );
				}
			}
			$('#version').trigger("liszt:updated");
			$('#version').trigger("change");
		});
	});
	
	$('#selCounty').change(function(){
		$.get('/portal/getSubstation',{countycode:$(this).val()},function(data){
			eval('var ret =' + data);
			$('#selSubstation').empty();
			$('#selSubstation').append('<option value="">所有局站</option>' );
			for(i = 0 ; i < ret.substationList.length ; i++)
			{
				var substationObj = ret.substationList[i];
				$('#selSubstation').append('<option value="'+ substationObj.id +'">'+ substationObj.name +'</option>' );
			}
			$('#selSubstation').trigger("liszt:updated");
			$('#selSubstation').trigger("change");
		});
	});
	$('#selSubstation').change(function(){
		$.get('/portal/getroom',{substation_id:$(this).val()},function(data){
			eval('var ret =' + data);
			$('#selRoom').empty();


			$('#selRoom').append('<option value="">所有机房</option>' );

			for(i = 0 ; i < ret.roomList.length ; i++)
			{
				var roomObj = ret.roomList[i];
				$('#selRoom').append('<option value="'+ roomObj.id +'">'+ roomObj.name +'</option>' );
			}

			$('#selRoom').trigger("liszt:updated");

		});
		$.get('/portal/getSmdDev',{selsubstation_id:$(this).val()},function(data){
			eval('var ret =' + data);
			$('#selSmdDev').empty();
			$('#selSmdDev').append('<option value="">所有采集板</option>' );
			for(i = 0 ; i < ret.smdDevList.length ; i++)
			{
				
				var smdDevObj = ret.smdDevList[i];
				$('#selSmdDev').append('<option value="'+ smdDevObj.device_no +'">'+ smdDevObj.name +'</option>' );
			}
			$('#selSmdDev').trigger("liszt:updated");
		});
		
	});
//	$('#selRoom').change(function(){
//		$.get('/portal/getSmdDev',{selRoom_id:$(this).val()},function(data){
//			eval('var ret =' + data);
//			$('#selSmdDev').empty();
//			$('#selSmdDev').append('<option value="">所有采集板</option>' );
//			for(i = 0 ; i < ret.smdDevList.length ; i++)
//			{
//				
//				var smdDevObj = ret.smdDevList[i];
//				$('#selSmdDev').append('<option value="'+ smdDevObj.device_no +'">'+ smdDevObj.name +'</option>' );
//			}
//			$('#selSmdDev').trigger("liszt:updated");
//		});
//	});
	function getAlertCount()
	{
		$.get('/portal/getRtAlarmCount',{citycode:0},function(ret){
			//eval('var ret =' + data);
			$('#notify-alert-all').html(ret.totalCount);
			$('#notify-alert-level1').html(ret.level1);
			$('#notify-alert-level2').html(ret.level2);
			$('#notify-alert-level3').html(ret.level3);
			$('#notify-alert-level4').html(ret.level4);
		});
	}
	getAlertCount();
	setInterval(getAlertCount,20000);
});
