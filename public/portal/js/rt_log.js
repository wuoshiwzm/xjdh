$(document).ready(function(){
	
	$(".rtlog").each(function(index){
		var ulLog = $(this);
		var subscriber = new JSMQ.Subscriber();
        subscriber.connect("ws://" + window.location.host + ":14002");
        subscriber.subscribe($(this).attr("data_id") + " ");

        subscriber.onMessage = function (message) {
        	ulLog.prepend("<li>" + message.popString() + "</li>");
        };

	});
});
