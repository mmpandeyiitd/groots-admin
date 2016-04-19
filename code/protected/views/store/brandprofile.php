
<?php
$store_id = Yii::app()->session['brand_id'];
if (isset($_GET['store_id']) && !empty($store_id)) {
    if ($store_id != $_GET['store_id']) {
        Yii::app()->user->setFlash('permission_error', 'You are doing something wrong!.');
        $this->redirect(array('DashboardPage/index'));
    }
}
//$data = Store::findAllByAttributes(array('store_id' => $brand_id));
?>
<div class="profileDetail">
    <h3 style=" text-align: center;">My Profile  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo CHtml::link('Edit Profile', array('store/update', "id" => $model->store_id)); ?></h3> 
    <table class="table table-hover profile-table">
        <tbody>
            <tr>
                <td>Contact Person:
                <td><?php echo $model->seller_name; ?></td>
                </td>
            </tr>
            <tr>
                <td>Brand Name:</td>
                <td><?php if (!empty($model->store_name)) {
    echo $model->store_name;
} else {
    echo "N/A";
} ?></td>
            </tr>

            <tr>
                <td>System ID:</td>
                <td><?php echo $model->store_id; ?></td>
            </tr>
           
            <tr>
                <td>Email ID:</td>
                <td><?php if (!empty($model->email)) {
    echo $model->email;
} else {
    echo "N/A";
} ?></td>
            </tr>

            </tr>
            <tr>
                <td>Status:</td>
                <td> <?php if ($model->status) {
    echo 'Published';
} else {
    echo 'UnPublished';
}; ?></td>
            </tr>

            <tr>
                <td>Mobile No.:</td>
                <td><?php if (!empty($model->mobile_numbers)) {
    echo $model->mobile_numbers;
} else {
    echo "N/A";
} ?></td>
            </tr>

            <tr>
                <td>Address:</td>
                <td><?php if (!empty($model->business_address)) {
                        echo $model->business_address;
                    } else {
                        echo "N/A";
                    } ?></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><?php if (!empty($model->business_address_city)) {
                        echo $model->business_address_city;
                    } else {
                        echo "N/A";
                    } ?></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><?php if (!empty($model->business_address_state)) {
                        echo $model->business_address_state;
                    } else {
                        echo "N/A";
                    } ?></td>
            </tr>

            <tr>
                <td>Country:</td>
                <td><?php
                    if (!empty($model->business_address_country)) {
                        echo $model->business_address_country;
                    } else {
                        echo "N/A";
                    }
?>
                </td>
            </tr>

            <tr>
                <td>Pin code:</td>
                <td><?php
                    if (!empty($model->business_address_pincode)) {
                        echo $model->business_address_pincode;
                    } else {
                        echo "N/A";
                    }
?></td>
            </tr>
            <tr>
                <td>Brand Detail:</td>
                <td><?php if (!empty($model->store_details)) {
                        echo $model->store_details;
                    } else {
                        echo "N/A";
                    } ?></td>
            </tr>

            <tr>
                <td>Tags:</td>
                <td><?php if (!empty($model->tags)) {
                        echo $model->tags;
                    } else {
                        echo "N/A";
                    } ?></td>
            </tr>

            <tr>
                <td>Brand Logo:</td>
                <td> <img src="<?php echo $model->store_logo_url; ?>" width="90px;" hieght="80px"></td>
            </tr>
            <tr>
                <td>LifeStyle Image:</td>
                <td> <img src="<?php echo $model->image_url; ?>" width="90px;" hieght="80px"></td>
            </tr>
        </tbody></table>

    <!--                <h3>Store images:</h3>
                    <ul class="storeImg">
<?php
// $media = array();
//$media = MediaRetailer::model()->getMediaByRetailerId($model->id);
// if (isset($media)) {
//    $i=0;
//   foreach ($media as $_media) { 
?>
                        <li><a href="<?php // echo $_media['media_url'];  ?>" data-lightbox="example-1"><img src="<?php //echo $_media['thumb_url'];  ?>" alt="image-<?php /// echo $i; ?>"></a></li>
<?php //$i++; }} ?>
                    </ul>-->
</div>

<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/themes/abound/css/lightbox.css"> 
<script src="<?php echo Yii::app()->baseUrl; ?>/themes/abound/js/lightbox.js"></script>
