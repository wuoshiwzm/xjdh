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
        area: ["900px", "550px"],
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

//关闭窗口
//关闭iframe
// $('#closeIframe').click(function(){
//     alert(1231);
//     parent.layer.close(index);
//
// });