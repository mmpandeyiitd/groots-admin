<div class="profileDetail">
                <!-- <h3>My Profile</h3> -->
                <table class="table table-hover profile-table">
                  <tbody>
                      
                   <tr>
                    <td>Name:</td>
                        <td><?php if (!empty($model->name)){echo $model->name;} else { echo "N/A";} ?></td>
                  </tr>
                  
                   <tr>
                    <td>System ID:</td>
                    <td><?php echo $model->id;?></td>
                  </tr>
                  
                  <tr>
                    <td>Retailer Code:</td>
                    <td><?php if (!empty($model->retailer_code)){echo $model->retailer_code;} else { echo "N/A";} ?></td>
                  </tr>
                  
                   <tr>
                    <td>Email ID:</td>
                    <td><?php if (!empty($model->email)){echo $model->email;} else { echo "N/A";} ?></td>
                  </tr>
                  
                  <tr>
                    <td>VAT Number:</td>
                     <td><?php if (!empty($model->VAT_number)){echo $model->VAT_number;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Address:</td>
                     <td><?php if (!empty($model->address)){echo $model->address;} else { echo "N/A";} ?></td>
                  </tr>
                   <tr>
                    <td>Telephone:</td>
                     <td><?php if (!empty($model->telephone)){echo $model->telephone;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Web Site:</td>
                    <td><?php if(!empty($model->website)){?><a href="<?php echo $model->website;?>" target="_blank"><?php echo $model->website; ?></a><?php }else{ echo "N/A" ;}?></td>
                  </tr>
                  <tr>
                    <td>Contact Person/Designation/No. 1:</td>
                     <td><?php if (!empty($model->contact_perssion1)){echo $model->contact_perssion1;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Contact Person/Designation/No. 2:</td>
                    <td><?php if (!empty($model->contact_perssion2)){echo $model->contact_perssion2;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Store Size:</td>
                    <td><?php if (!empty($model->store_size)){echo $model->store_size;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Product Categories:</td>
                     <td><?php if (!empty($model->product_categories)){echo $model->product_categories;}else { echo "N/A";} ?></td>
                  <tr>
                    <td>Key Brands Stocked:</td>
                     <td><?php if (!empty($model->key_brand_stocked)){echo $model->key_brand_stocked;} else { echo "N/A";} ?></td>
                  </tr>
                  <tr>
                    <td>Categories of interest:</td>
                    <td><?php if (!empty($model->categories_of_interest)){echo $model->categories_of_interest;} else { echo "N/A";} ?></td>
                  </tr>
                </tbody></table>

                <h3>Store images:</h3>
                <ul class="storeImg">
                     <?php
            $media = array();
            $media = MediaRetailer::model()->getMediaByRetailerId($model->id);
            if (isset($media)) {
                   $i=0;
                   foreach ($media as $_media) { ?>
                    <li><a href="<?php echo $_media['media_url']; ?>" data-lightbox="example-1"><img src="<?php echo $_media['thumb_url']; ?>" alt="image-<?php echo $i;?>"></a></li>
                <?php $i++; }}?>
                </ul>
            </div>

  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/themes/abound/css/lightbox.css"> 
<script src="<?php echo Yii::app()->baseUrl;?>/themes/abound/js/lightbox.js"></script>
