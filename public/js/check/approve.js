/**
 * Created by jim on 2017/2/22.
 */

//跳转审核页面
$(".approve").bind("click", function () {
    $res = $(this).parent().find($("input")).val();
    layer.open({
        type: 2,
        area: ["900px", "550px"],
        fixed: false, //不固定
        maxmin: true,
        content: "/check/approve/" + $res,
    });
});

//跳转编辑安排页面
$(".editArrange").bind("click", function () {

    $res = $(this).parent().find($("input")).val();
    layer.open({
        type: 2,
        area: ["900px", "250px"],
        fixed: false, //不固定
        maxmin: true,
        content: "/check/editArrange/" + $res,
    });
});

//
$(".approveImg").bind("click", function () {
    $res = $(this).parent().find($("input")).val();

    layer.open({
        type: 2,
        area: ["400px", "500px"],
        fixed: false, //不固定
        maxmin: true,
        content:  $res,
    });
});

$(".update").bind("click",function () {

    var id = $(this).parent().parent().find(".id").val();
    var order = $(this).parent().parent().find(".order").val();
    var content = $(this).parent().parent().find(".content").val();
    var desc = $(this).parent().parent().find(".desc").val();



    if(content==''){
        alert('一个填写问题内容必填');
    }else{
        $.post("updateQuestion",{"id":id,"order":order,"content":content,"desc":desc},function(data){
            if(data == 'true'){
                alert('更新成功！');
                location.reload();
            }
        });
    }
});

$(".updatePeople").bind("click",function () {

    var userID = $(this).parent().parent().find(".userID").val();
    var role = $(this).parent().parent().find(".userRole").val();

        $.post("updateRole",{"userID":userID,"role":role},function(data){
            if(data == 'true'){
                alert('更新成功！');
                location.reload();
            }
        });

});




$(".confirmArrange").bind("click",function () {
    var user = $("#user").find("option:selected").text();
    var sub = $("#sub").find("option:selected").text();

    if (window.confirm("确认安排督导："+$.trim(user) +" 验收局站： "+ $.trim(sub)+"?")) {
        return true;
    }
    return false;

});



//关闭窗口
//关闭iframe
// $('#closeIframe').click(function(){
//     alert(1231);
//     parent.layer.close(index);
//
// });
