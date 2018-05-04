<div class="search-banner hidden" ng-controller="searchBusinessController">
    <div class="container">
        <div class="text-right pt20">
            <?php if($isbusinessdeactivate == false){ ?>
              <a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
            <?php }else{ ?>
              <a class="btn5" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
            <?php } ?>
        </div>
        <div class="search-bnr-text">
            <h1>Find The Business That Fits Your Life</h1>
        </div>
        <div class="search-box">
            <form ng-submit="searchSubmit()">
                <div class="search-input">
                    <input type="text" ng-model="keyword" id="q" name="q" placeholder="Company, Cat, Products" autocomplete="off">
                    <input type="text" ng-model="city" id="l" name="l" placeholder="Location" autocomplete="off">
                    <input type="submit" class="btn1" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- NEW HTML DESIGN -->
 <div class="search-banner" >
<!--     <header>
     <div class="header">
      <div class="container">
       <div class="row">
        <div class="col-md-6 col-sm-6 left-header">
         <h2 class="logo"><a href="#">Aileensoul</a></h2>
         
        </div>
        <div class="col-md-6 col-sm-6 right-header">
         <ul>
          <li>
           
          </li>
          <li>
           
          </li>
         </ul>
        </div>
       </div>
      </div>
     </div>
    </header> -->
   
    <div class="container">
      <div class="text-right pt20">
          <?php if($isbusinessdeactivate == false || !($isbusinessdeactivate)){ ?>
            <a class="btn5" href="<?php echo $business_profile_link ?>">Create Business Profile</a>
          <?php }else{ ?>
            <a class="btn5" href="<?php echo base_url('business-profile/registration/business-information') ?>">Reactive Business Profile</a>
          <?php } ?>
      </div>
     <div class="row">
      <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
       <div class="search-bnr-text">
        <h1>Find The Business That Fits Your Life</h1>
       </div>
       <div class="search-box">
        <form ng-submit="searchSubmit()">
         <div class="pb20 search-input">
          <input type="text" ng-model="keyword" id="q" name="q" placeholder="Company, Cat, Products" autocomplete="off">
          <input ng-model="city" id="l" name="l" placeholder="Location" autocomplete="off">
          
         </div>
         <div class="pt5 fw pb20">
          <ul class="work-timing fw">
           <li>
            <label class="control control--checkbox">Full-Time
              <input type="checkbox"/>
              <div class="control__indicator"></div>
            </label>
           </li>
           <li>
            <label class="control control--checkbox">Part-Time
              <input type="checkbox"/>
              <div class="control__indicator"></div>
            </label>
           </li>
           <li>
            <label class="control control--checkbox">Internship
              <input type="checkbox"/>
              <div class="control__indicator"></div>
            </label>
           </li>
          </ul>
         </div>
         <div class="fw pt20">
          <a href="#" class="btn1">Find Business</a>
         </div>
        </form>
       </div>
      </div>
     </div>
    </div>
   </div>

