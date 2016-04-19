<?php
#....
include('config.php');
@$last_msg_id = $_GET['last_msg_id'];

@$action = $_GET['action'];


if ($action <> "get") {
    ?>


    <script type="text/javascript">
        $(document).ready(function () {

            function last_msg_funtion()
            {

                var ID = $(".message_box:last").attr("id");
                var store_id =<?php Yii::app()->request->getQuery('store_id'); ?>
                $('div#last_msg_loader').html('<img src="bigLoader.gif">');

                var param = "store_id=" + store_id + "&action=getRes&last_msg_id=" + ID;
                $.ajax({
                    type: "POST",
                    url: "http://localhost/y_brandadmin/code/index.php?r=baseProduct/load_first_1",
                    data: param,
                    success: function (data) {
                        
                        if (data != "") {
                                $(".message_box:last").append(data);
                                }
                                $('div#last_msg_loader').empty();
                    }
                });


//                $.post("http://localhost/y_brandadmin/code/index.php?r=baseProduct/admin_1&store_id=" + store_id + "&action=get&last_msg_id=" + ID,
//                        function (data) {
//                            console.log("mydata" + data);
//                            if (data != "") {
//                                $(".message_box:last").after(data);
//                            }
//                            $('div#last_msg_loader').empty();
//                        });
            }
            ;

            $(window).scroll(function () {
                if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                    last_msg_funtion();
                }
            });

        });
    </script>

    <div align="center">
        <?php
        include('load_first.php');
        ?>
        <div id="last_msg_loader"></div>
    </div>
    <?php
} else {

    include('load_second.php');
}
?>	

<style type="text/css">
    .modal-backdrop, .modal-backdrop.fade.in {opacity: 0.2;}
    #floatbar {
        position:relative;
    }

    .popup {
        position:absolute;
        top:10px;
        left:0px;
        height:30px;
        background:#ccc;
        display:none;
    }
</style>