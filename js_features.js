/*---------------------------------Cookie---------------------------*/
    function setCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

    function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

    var modal = getCookie('modal');

    if($('.template-index').length && modal != '1' ) {
        setCookie('modal', '1', 1);
        setTimeout(function() {
          $('.modal-subscribe').fadeIn(400).addClass('modal-show');
        }, 10000);
    }


/*---------------------------------AJAX---------------------------*/

    var popup = 0;
        doc.on( 'click', '.popup-page', function(){
            var page = $(this).attr('href');
            var data = $('#form').find('input[type="hidden"], input[type="text"], input[type="number"], input[type="radio"]:checked, select, textarea');

            if( !popup ){
                popup = 1;
                $.ajax({
                    // url:page,
                    url:ajaxurl,
                    // data: data,
                    data: $('#form').find( 'input, select, textarea' ).serialize(),
                    // data: { action: 'saveShop', id:2 },
                    dataType: 'html', //'json'
                    type: "POST", // GET
                    success:function(data){
                        popup = 0;
                        $('#popupPage').fadeIn(400).addClass('modal-show').find('.modal-content-block').attr('data-offset', 60).html(data);

                        console.log(data);
                        // $('.ajax_restore').html(data);
                        // $('.ajax_restore').slideDown(200);
                    },
                    error: function(responce){
                        console.log(responce);
                        popup = 0;

                    }
                });
            }
            return false;
        });


        function bindButtonClick(){
            $('.myClickableElement').click(function(){
                //... event handler code ...
            });
        }

        bindButtonClick();
        $(document).ajaxComplete(function(){
            bindButtonClick();
        });

/*---------------------------------Change url without reload page---------------------------*/
        pageurl = $(this).attr('href'); //url new page
        if(pageurl!=window.location){
          window.history.pushState({path:pageurl},'',pageurl);
        }

/*---------------------------------custom validate form---------------------------*/
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,7})+$/;
        return regex.test(email);
    }

        $('button[type="submit"]').on('click', function(e){
            e.preventDefault(); 
            $('.error').removeClass('error');

            // console.log('send');
            const form = $(this).closest('form');
            console.log(form.find('[required]'));
            form.find('[required]').each(function(i){
                if( $(this).val()=='' || ($(this).attr('type')=='email' && !isEmail($(this).val()) ) ){
                    $(this).addClass('error');
                    console.log($(this).attr('name'));
                    $('.acf-spinner').hide(10);
                    ajax=1;
                    // return false;
                }
                if(i+1 == form.find('[required]').length && form.find('input.error').length == 0 && form.find('textarea.error').length == 0 && form.find('select.error').length == 0 ){
                    console.log(form);

                    ajax=0;
                    form.submit();
                    form.trigger('submit');
                }
            // console.log('submit3');
            });
            console.log('submit3');
            return false;
        });
/*--------------------------------disable click enter--------------------------*/
    $(document).keypress(
      function(event){
        if (event.which == '13') {
          event.preventDefault();
        }
    });
/*--------------------------------catch what element was clicked - clear js--------------------------*/

function getClickedElement(e){
  if (navigator.userAgent.match('MSIE') || navigator.userAgent.match('Gecko')) {
  var elem = document.elementFromPoint(e.clientX,e.clientY);
  } else {
  var elem = document.elementFromPoint(e.pageX,e.pageY);
  }
  console.log(elem); 
  
  return elem;
}
document.body.onclick = function(e) {
    e = e || window.event;
    elem = getClickedElement(e);
    if ( !elem.classList.contains('dropdown-toggle')) {
      e.preventDefault(); // not working
        return false;// not working
    }
    //здесь можете работать с элементом
}

$(document).click(function(e){
            var target = e.target;
            console.log(target);
        });

/*-------------------------------- выравнивание блоков в линии по высоте --------------------------*/

function equalHeight(element) {
        var maxHeightTabBlock = 0;
        $(element).outerHeight('');
        $(element).each(function() {
            if ($(this).outerHeight() > maxHeightTabBlock) {
                maxHeightTabBlock = $(this).outerHeight();
            }
            return maxHeightTabBlock;
        });
        $(element).outerHeight(maxHeightTabBlock);
    }
    equalHeight(element);