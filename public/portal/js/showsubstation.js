$(document).ready(function(){
	$(function () {
		var windowsArr = [];
	    var marker = [];
	    var Lnglat = $("#txtLnglat").attr("value"); 
	    var arra;
	    var defaultLayer = new AMap.TileLayer();  // 默认地址	
	    var traffic = new AMap.TileLayer.Traffic();
	    
	    window.onload = function(){
			var arr = document.getElementsByTagName('input');
			for(var i = 0;i<arr.length;i++){
				arr[i].onclick = function(){
					if(this.id!="keyword" && this.id!="txtLnglat")
					window.location.href="/portal/showsubstation/"+this.id; 
				}
			}
		}
	    
	    if(layer=="0"||layer=="road"){
	    	var map = new AMap.Map('container',{//实时路况
		        zoom: 13,                       //加载地图
			    resizeEnable: true,
			    keyboardEnable: false,
			    isHotspot: true,
			    center: [87.613733,43.798513]
	        });	
	    }
			
	    if(layer=="satellite"){
	    	var map = new AMap.Map('container', {//卫星图层
		        center: [87.613733,43.798513],
		        layers: [new AMap.TileLayer.Satellite()],
		        resizeEnable: true,
			    keyboardEnable: false,
		        isHotspot: true,
		        zoom:13
	        });
	    }
	    
	    if(layer=="floor"){
		    var map = new AMap.Map("container", {//3D楼块图层
		        resizeEnable: true,
		        center: [87.613733,43.798513],
		        zoom: 13
		    });
		    if (document.createElement('canvas') && document.createElement('canvas').getContext && document.createElement('canvas').getContext('2d')) {
		        // 实例化3D楼块图层
		        var buildings = new AMap.Buildings();
		        // 在map中添加3D楼块图层
		        buildings.setMap(map);
		    } else {
		        document.getElementById('tip').innerHTML = "对不起，运行该示例需要浏览器支持HTML5！";
		    }
	    }
	    
//		traffic.setMap(map);
//	    function refresh(e) {
//            map.setMapStyle("dark");
//        }
	     
		AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],  //地图控件	
	    function(){
            map.addControl(new AMap.ToolBar());
            map.addControl(new AMap.Scale());
            map.addControl(new AMap.OverView({isOpen:true}));      
		});
		 
	    AMap.plugin(['AMap.Autocomplete','AMap.PlaceSearch'],function(){
	        var autoOptions = {
	           city: "", //城市，默认全国
	           input: "keyword"//使用联想输入的input的id
	        };
	        autocomplete= new AMap.Autocomplete(autoOptions);
	        var placeSearch = new AMap.PlaceSearch({
	            city:'',
	            map:map
	        })
	        AMap.event.addListener(autocomplete, "select", function(e){
	           //TODO 针对选中的poi实现自己的功能
	           placeSearch.search(e.poi.name)
	        });
	    });
		    
		    //鼠标拾取地图坐标
	    var clickEventListener = map.on('click', function(e) {
	        //document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat()
	        document.getElementById("txtLnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat()
	    });
	    var auto = new AMap.Autocomplete({
	        input: "tipinput"
	    });
	    AMap.event.addListener(auto, "select", select);//注册监听，当选中某条记录时会触发
	    function select(e) {
	        if (e.poi && e.poi.location) {
	            map.setZoom(15);
	            map.setCenter(e.poi.location);
	        }
	    }
		
	    //地图热点
	    var placeSearch = new AMap.PlaceSearch();  //构造地点查询类
	    var infoWindow=new AMap.AdvancedInfoWindow({});
	    map.on('hotspotclick', function(result) {
	        placeSearch.getDetails(result.id, function(status, result) {
	            if (status === 'complete' && result.info === 'OK') {
	                placeSearch_CallBack(result);
	            }
	        });
	    });
	    //回调函数
	    function placeSearch_CallBack(data) { //infoWindow.open(map, result.lnglat);
	        var poiArr = data.poiList.pois;
	        var location = poiArr[0].location;
	        infoWindow.setContent(createContent(poiArr[0]));
	        infoWindow.open(map,location);
	    }
	    function createContent(poi) {  //信息窗体内容
	        var s = [];
	        s.push('<div class="info-title">'+poi.name+'</div><div class="info-content">'+"地址：" + poi.address);
	        s.push("电话：" + poi.tel);
	        s.push("类型：" + poi.type);
	        s.push('<div>');
	        return s.join("<br>");
	    }
	    
	    //加载公交换乘插件
	    AMap.service(["AMap.Transfer"], function() {
	        var transOptions = {
	            map: map,
	            //city: '北京市',
	            panel:'panel',                            //公交城市
	            cityd:'乌鲁木齐',
	            policy: AMap.TransferPolicy.LEAST_TIME //乘车策略
	        };
	        //构造公交换乘类
	        var trans = new AMap.Transfer(transOptions);
	        //根据起、终点坐标查询公交换乘路线
	        trans.search([{keyword:'北京市地震局(公交站)'},{keyword:'望京西园4区'}], function(status, result){
	        });
	    });
		    
	    var contextMenu = new AMap.ContextMenu();  //创建右键菜单
	    //右键放大
	    contextMenu.addItem("放大一级", function() {
	        map.zoomIn();
	    }, 0);
	    //右键缩小
	    contextMenu.addItem("缩小一级", function() {
	        map.zoomOut();
	    }, 1);
	    //右键显示全国范围
	    contextMenu.addItem("缩放至全国范围", function(e) {
	        map.setZoomAndCenter(4, [108.946609, 34.262324]);
	    }, 2);
	    //右键添加Marker标记
	    contextMenu.addItem("添加标记", function(e) {
	        var marker = new AMap.Marker({
	            map: map,
	            position: contextMenuPositon //基点位置
	        });
	    }, 3);

	    //地图绑定鼠标右击事件——弹出右键菜单
	    map.on('rightclick', function(e) {
	        contextMenu.open(map, e.lnglat);
	        contextMenuPositon = e.lnglat;
	    });	     

	    ch = new Array;
	    ch = name.split(",");
	    var infoWindow = new AMap.InfoWindow();
	    for(var i=0, marker;i<=ch.length;i++){
			if(lng[i]!="0" && lat[i]!="0"){
			     marker=new AMap.Marker({
	                position:new AMap.LngLat(lng[i],lat[i]),
	                map:map
	             });
	         marker.content = ch[i];
	         marker.on('click', markerClick);
		    }	
			function markerClick(e){
	 	        infoWindow.setContent(e.target.content);
	 	        infoWindow.open(map, e.target.getPosition());   
		    }
	    }
	    map.setFitView();

	    
	    

	});
});
