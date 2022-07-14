$(function () {
        
        get_captcha();
        getdate();
        function getdate() {
          $.get( "<?php echo base_url().'login/get_microtime' ?>", function( data ) {
             //$("#timer").html(data);
          });        
          setTimeout(function () { getdate() }, 1000);
        }
        function get_captcha(){
          $.getJSON( "<?php echo base_url().'login/captcha_refresh' ?>", function( data ) {
              $('img#captchaImage').attr('src',uri_img+data['filename']);
              $('input#CaptchaDeText').val(data['word']);
          });
        }
        $('#refresh').click(function(){
          get_captcha();
        });

        $('#form1').submit(function(){
          var url = $(this).attr('action');
          var CaptchaDeText = $('#CaptchaDeText').val();
          var CaptchaInputText = $('#CaptchaInputText').val();
          if(CaptchaDeText == CaptchaInputText){

            $.ajax({
              type    : "POST",
              url     : url,
              data    : $(this).serialize(), 
              dataType: "JSON",
              success : function(data){
                if(data.error){
                 location.href=data.message;
                }else{
                 alert(data.message);                  
                }
              }
            });
          
          }else{
            alert('Code yang anda inputkan tidak sama. Silahkan coba lagi.');
            get_captcha();
          }
        });
    });