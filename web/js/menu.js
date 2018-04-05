$(document).ready(function () {
    $('#cats > .btn').click(function () {
        var id =  $(this).attr('cat-id');
        var menu =  $(this).attr('menu-id');
        var _csrf = $(this).attr('_csrf');
        var is_exist = $('#menu').find('[cat-id='+id+']').attr('cat-id');
        if (is_exist){
            return false;
        }
        $.ajax({
            type:'post',
            data:{
                id: id,
                menu:menu,
                _csrf:_csrf
            },
            url:'add-menu-cat',
            success:function (data) {

                $('#menu').append(data);
            },
            error:function () {
                console.log('error')
            }
        })
    })


    $('#pages > .btn').click(function () {
        var id =  $(this).attr('page-id');
        var menu =  $(this).attr('menu-id');
        var _csrf = $(this).attr('_csrf');
        var is_exist = $('#menu').find('[page-id='+id+']').attr('page-id');;
        if (is_exist){
            return false;
        }
        $.ajax({
            type:'post',
            data:{
                id: id,
                menu:menu,
                _csrf:_csrf
            },
            url:'add-menu-page',
            success:function (data) {
                $('#menu').append(data);
            },
            error:function () {
                console.log('error')
            }
        })
    })

    $(document).on('click','.btn-success',function () {
        var page_id =  $(this).attr('page-id');
        var that = $(this);
        var wtf , id;
        var cat_id =  $(this).attr('cat-id');
        var menu =  $(this).attr('menu-id');
        var _csrf = $(this).attr('_csrf');
        if(page_id){
            wtf = 1;
            id = page_id;
        }
        else{
            wtf = 2;
            id = cat_id;
        }
        $.ajax({
            type:'post',
            data:{
                id: id,
                menu:menu,
                _csrf:_csrf,
                wtf:wtf
            },
            url:'delete-menu',
            success:function () {
                that.remove();
            },
            error:function () {
                console.log('error')
            }
        })
    })
})

