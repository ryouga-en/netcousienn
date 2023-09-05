$(function() {
 
  $('.menu-icon').click(
    function() {
       //.showクラスを切り替える
       $('.menu-icon').toggleClass('show');
       //showクラスを持っていれば、ex05-div-areaを表示、持っていなければ非表示
       if($('.menu-icon').hasClass('show')){
           $('.menu').show();
       }else{
           $('.menu').hide();
       }
  });
 
 
 
});
$(function() {
 
  $('.reply-icon').click(
    function() {
       //.showクラスを切り替える
       $('.reply-icon').toggleClass('show');
       //showクラスを持っていれば、ex05-div-areaを表示、持っていなければ非表示
       if($('.reply-icon').hasClass('show')){
           $('.kie').show();
       }else{
           $('.kie').hide();
       }
  });
 
 
 
});

 
