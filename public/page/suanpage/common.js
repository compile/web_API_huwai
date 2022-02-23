$(function(){

  // var index;
  // $('.index-top-tab span').click(function(){
  //   index = $(this).index()
  //   $('.index-top-tab span').removeClass('active')
  //   $(this).addClass('active')
  //   $('.index-cont').hide('slow')
  //   $('.index-top-cont').children('.index-cont').eq(index).show('slow')
  // })

  var index,dis;
  $('body').on('click','.index-top-tab span',function(){
    $('.index-hot').hide()
    $('.city-list').show()
    index = $(this).index() - 1;
    dis = 0;
    dis = dis - $('.city-list section').eq(0).height();
    $('.city-list section').eq($(this).index() - 1).prevAll().each(function(i,v){
      dis += $(v).height()
    });  
    $('.city-list').scrollTop(dis);
    
    $('.city-list').children('section').removeClass('active');
    $('.city-list').children('section').eq(index).addClass('active');

    $('.index-top-tab span,.city-hot').removeClass('active')
    $(this).addClass('active')

  })
  $('body').on('click','.city-hot',function(){
    $('.index-top-tab span').removeClass('active')
    $(this).addClass('active')
    $('.index-hot').show()
    $('.city-list').hide()
  })
  $('body').on('click','.city-sele-result',function(){
    $(this).parent().siblings().find('.city-sele-option').hide()
    $(this).parent().find('.city-sele-option').toggle()
  })
  $('body').on('click','.city-sele-option p',function(){
    $('.city-sele-option').hide()
    $(this).parent().parent().find('.city-sele-result span').html($(this).html());
  })
 
  var index01;
  $('.nav-col').hover(function(){
    index01 = $(this).index()
    $(this).addClass('active01')
    $('.nav-cont-div').hide()
    $('.nav-cont').children().eq(index01).toggle()
  },function(){
    $(this).removeClass('active01')
    
  })
  $('.nav-cont').mouseleave(function(){
    $('.nav-cont').children().stop().hide('fast')
  })

  function tabClick(tabName,contName,contCol,className,ani){
    var index;
    $(tabName).click(function(){
      index = $(this).index()
      $(tabName).removeClass(className)
      $(this).addClass(className)
      $(contCol).hide(ani)
      $(contName).children(contCol).eq(index).show(ani)
    })
  }
  function tabHover(tabName,contName,contCol,className,contAll,ani){
    var index;
    $(tabName).hover(function(){
      index = $(this).index()
      $(tabName).removeClass(className)
      $(this).addClass(className)
      $(this).parents(contAll).find(contCol).stop().hide(ani)
      $(this).parents(contAll).find(contName).children(contCol).eq(index).stop().show(ani)
    },function(){

    })
  }

  // $('body').on('click','.code-confirm',function(){
  //   $('.sign-code-pop').fadeOut();
	// 	var _this =$('.sign-input-span');
	// 	if(_this.hasClass('getCode')){

	// 		var html = '获取验证码';
	// 		_this.removeClass('getCode').html('<span>60s</span>后可重新获取');
	// 		var t = 60;
	// 		setInterval1 = setInterval(function(){
	// 			t--;
	// 			_this.html('<span>'+t+'s</span>后可重新获取');

	// 			if(t==0) {
	// 				clearInterval(setInterval1);
	// 				_this.html(html).addClass('getCode').html(html);
	// 			}
	// 		},1000);

	// 	}else{
	// 		return;
	// 	}
	// })

  // $('body').on('click','.sign-input-span',function(){
  //   if($(this).hasClass('getCode')){
  //     $('.sign-code-pop').toggle()
  //   }
  // })
  function isPoneAvailable(str) {
    var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
    if (!myreg.test(str)) {
      return false;
    } else {
      return true;
    }
  }
  function isUserName(str){
    var char=/^[a-zA-Z0-9]{4,}$/;
    if(!char.test(str)){
      return false;
    }else{
      return true;
    }
  }
  $('body').on('input','.input-tel',function(){
    console.log(isPoneAvailable($(this).val()))
    if ( isPoneAvailable($(this).val()) ){
      $('.sign-ri-btn').addClass('active','active-a')
    }else{
      $('.sign-ri-btn').removeClass('active','active-a')
    }
  })
  $('body').on('input','.input-name',function(){
    if ( isUserName($(this).val()) ){
      $('.sign-ri-btn').addClass('active','active-a')
    }else{
      $('.sign-ri-btn').removeClass('active','active-a')
    }
  })
  if($('.input-name').val()){
    
  }
  function toggleImg(className){
    $('body').on('click',className,function(){
      $(this).find('img').toggle()
    })
  }
  toggleImg('.sign-rem')
  tabClick('.sign-ri-tab span','.sign-ri-cont','.sign-cont-col','active')

  var str,strSrc;
  $('.index-04-icon a').hover(function(){
    str = $(this).find('img').attr('src')
    strSrc = str.substring(0,str.length-4)
    $(this).find('img').attr('src',strSrc+'-light.png')
  },function(){
    $(this).find('img').attr('src',str)
  })

  $('body').on('click','.read',function(){
    $('label img').toggle()
  });
  function toggleActive(className){
    $('body').on('click',className,function(){
      $(this).parent().children().removeClass('active','active-a')
      $(this).parent().siblings().children().removeClass('active','active-a')
      $(this).addClass('active','active-a')
    })
  }
  toggleActive('.xgt-tab span')
  toggleActive('.xgt-tab01-top span')
  toggleActive('.xgt-tab01-line section span')
  toggleActive('.xgt-line-box .xgt-none span')
  


  
})

