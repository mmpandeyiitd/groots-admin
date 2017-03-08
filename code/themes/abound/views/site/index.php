<?php 

if(isset(Yii::app()->session['checkAccess']))
  $this->redirect(array('DashboardPage/index'));
  else
   $this->redirect(array('site/login'));
  

?>    
	
	
	<div class="slider-bootstrap"><!-- start slider -->
    	<div class="slider-wrapper theme-default">
            <div id="slider-nivo" class="nivoSlider">
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/s10.jpg" data-thumb="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/s10.jpg" alt="" title="" />
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/s11.jpg" data-thumb="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/s11.jpg" alt="" title="" />
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/Branding.jpg" data-thumb="<?php echo Yii::app()->theme->baseUrl;?>/img/slider/flickr/Branding.jpg" alt="" title="" />
            </div>
        </div>

    </div> <!-- /slider -->
    
    
    <div class="shout-box">
        <div class="shout-text">
          <h1>Services @ CAN</h1>
         
        </div>
    </div>
    	<!--<div class="row-fluid">
            <ul class="thumbnails center">
              <li class="span3">
                <div class="thumbnail">
                <h3>Works on all devices</h3>
                  
                  	<div class="round_background r-grey-light">
                		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/smashing/30px-01.png" alt="" class="">
                     </div>
                  
                  <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
                </div>
              </li>
              <li class="span3">
                <div class="thumbnail">
                	 <h3>Unlimited color options</h3>
                     
                     <div class="round_background r-yellow">
                		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/smashing/30px-41.png" alt="" class="">
                     </div>
                 
                  <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
                </div>
              </li>
              <li class="span3">
                <div class="thumbnail">
                	<h3>6 home layouts</h3>
                  	<div class="round_background r-grey-light">
                		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/smashing/30px-37.png" alt="" class="">
                     </div>
                  <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
                </div>
              </li>
              <li class="span3">
                <div class="thumbnail">
                  <h3>More than 500 fonts</h3>
                  <div class="round_background r-yellow">
                		<img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/smashing/30px-17.png" alt="" class="">
                     </div>
                  <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
                </div>
              </li>

            </ul>
        </div>
        
        <hr>
        
        <div class="row-fluid">
            <div class="span9">
                <blockquote>
                  <h2>This is by far the best theme i have downloaded on webapplicationthemes.com. It was so easy to install and customize.</h2>
                  <small>Someone famous guy<cite title="Source Title"> - Harvard Business Review</cite></small>
                </blockquote>
            </div>
            
            <div class="span3" style="text-align:center;">
            
            <h3 class="text-error">What are you waiting for?</h3>
            
            <button class="btn btn-large btn-danger" type="button">DOWNLOAD IT NOW!</button>
            <p> <small>* terms and conditions apply</small></p>
            
            </div>
            
        </div>
       
      <h3 class="header">Cool features
        <span class="header-line"></span> 
      </h3>
        
	  <div class="row-fluid">
      	<div class="span4">
          
          <ul class="list-icon">
          	<li>Unlimited color options</li>
            <li>Responsive layout</li>
            <li>6 Homepage variations</li>
            <li>Portfolio layouts</li>
            <li>Multiple blog layouts</li>
            <li>HTML5</li>
            <li>CSS3</li>
            
          </ul>
       	 </div>
         
         <div class="span4">
          	<div class="showcase-small">
                <div class="text-icon pull-left">
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/fatcow/html_5.png" width="32" height="32" alt="Font" />
                </div>
                <h4>Valid HTML5</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          	</div>
            <div class="showcase-small">
                <div class="text-icon pull-left">
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/fatcow/css_3.png" width="32" height="32" alt="Font" />
                </div>
                <h4>CSS3 Support</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          	</div>
          </div>
          <div class="span4">
          	<div class="showcase-small">
                <div class="text-icon pull-left">
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/fatcow/layouts_header_2.png" width="32" height="32" alt="Font" />
                </div>
                <h4>Multiple layouts</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          	</div>
            <div class="showcase-small">
                <div class="text-icon pull-left">
                <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/icons/fatcow/cog_edit.png" width="32" height="32" alt="Font" />
                </div>
                <h4>Easy Customization</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          	</div>
          </div>
        
      </div>-->
      
      <h3 class="header">We Work With Amazing Names
      	<span class="header-line"></span>  
      </h3>
      <div class="row-fluid center customers">
        <div class="span3 ">
            <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/customers/amb.png" alt="amb" />
        </div>
        <div class="span3">
            <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/customers/im.png" alt="im" />
        </div>
        <div class="span3">
            <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/customers/ts.png" alt="ts" />
        </div>
        <div class="span3">
            <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/customers/delhi.png" alt="delhi" />
        </div>
          
		</div>
        
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/nivo-slider/jquery.nivo.slider.pack.js"></script>
    
     <script type="text/javascript">
    $(function() {
        $('#slider-nivo').nivoSlider({
			effect: 'boxRandom',
			manualAdvance:false,
			controlNav: false
			});
    });
    </script> <!--<script type="text/javascript">
    $(document).ready(function() {
        $('#slider-nivo2').nivoSlider();
    });
    </script>-->
