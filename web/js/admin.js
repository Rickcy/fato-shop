$(function () {
    function onClickPublicStatus(event) {
        var parent = $(event.currentTarget).parent();
        var pid = parent.attr('id');
        pid = pid.replace('gridRow', '');
        pid = pid.replace('ps', '');
        var type = 'ps';

        jQuery.ajax({
            type: 'POST',

            url: '/admin/change-status',
            data: {id:pid,type:type,'_csrf':yii.getCsrfToken()},
            success: function (data, textStatus) {
                $(parent).html("").append(jQuery(data).bind("click", onClickPublicStatus));
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }

    $('span.publicStatus').bind("click", onClickPublicStatus);




    var photoPath = []
    $('#imgGoods').change(function () {
        var input =$("#imgGoods");

        var id = $("#imgGoods").attr('product-id');

        var files = input[0].files;

        var data = new FormData();
        $.each( files, function( key, value ){
            data.append('photoGoodsFile', value )
        });
        $.ajax({
            type:'POST',
            url:'/admin/upload-photo?id='+id,
            data:data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success:function (data) {
                photoPath.push(data);
                $('#image-template').append("<span style='position: relative;margin: 1rem'><img class='img_good' style='max-width: 25%;margin: 10px' src="+data+" /><span title='Сделать основной' class='mainPhotoGood glyphicon glyphicon-ok' path='"+data+"'  ></span><span title='Удалить фото'  class='deletePhotoGood glyphicon glyphicon-remove' path='"+data+"' ></span></span>")
                $('#imgGoodsInput').val(photoPath);

            },
            error:function () {
                console.log('Error')
            }
        })
    });

    $('#upload-btn').click(function () {
       $(this).prev().click();
    });


    $(document).on('click','.mainPhotoGood',function () {
        var path = $(this).attr('path');
        var val = $('#imgGoodMain').val();

        $('.mainPhotoGood').removeClass('glyphicon-remove');
        $('.mainPhotoGood').addClass('glyphicon-ok');

        $('.img_good').css('border','none')




        if (val !== path){
            $(this).addClass('glyphicon-remove');
            $(this).prev('.img_good').css('border','5px #13ca3c solid');
            $('#imgGoodMain').val(path);
        }
        if (val === path){
            $(this).addClass('glyphicon-ok');
            $(this).prev('.img_good').css('border','none');
            $('#imgGoodMain').val('');
        }




    });


    $(document).on('click','.deletePhotoGood',function () {
        var path = $(this).attr('path');
        var self = $(this);
        $.ajax({
            type:'POST',
            url:'/admin/delete-photo-good',
            data:{'path':path},
            success:function (data) {
                if(data){
                    $(self).parent().remove();

                    photoPath.indexOf(path)
                    photoPath.splice(photoPath.indexOf(path), 1)
                    $('#imgGoodsInput').val(photoPath);

                }
            },
            error:function () {
                console.log('error')
            }
        })
    });


})