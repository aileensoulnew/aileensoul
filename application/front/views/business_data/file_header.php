<div class="media-tab pt15">
    <ul class="nav nav-tabs tabs-left">
        <li <?php if($this->uri->segment(3) == 'photos'){ echo 'class="active"'; } ?>> 
        	<a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/photos' ?>"><i class="fa fa-camera" aria-hidden="true"></i>  Photos</a>
        </li>
        <li <?php if($this->uri->segment(3) == 'videos'){ echo 'class="active"'; } ?>>
        	<a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/videos' ?>"><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</a>
        </li>
        <li <?php if($this->uri->segment(3) == 'audios'){ echo 'class="active"'; } ?>>
        	<a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/audios' ?>"><i class="fa fa-music" aria-hidden="true"></i>  Audio</a>
        </li>
        <li <?php if($this->uri->segment(3) == 'pdf'){ echo 'class="active"'; } ?>>
        	<a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/pdf' ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  Pdf</a>
        </li>
        <li <?php if($this->uri->segment(3) == 'article'){ echo 'class="active"'; } ?>>
            <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/article' ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i>  Article</a>
        </li>
    </ul>
</div>