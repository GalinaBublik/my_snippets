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

/*---------------------------------Change url without reload page---------------------------*/
        pageurl = $(this).attr('href'); //url new page
        if(pageurl!=window.location){
          window.history.pushState({path:pageurl},'',pageurl);
        }