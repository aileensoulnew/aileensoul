<input type = "hidden" class = "page_number" value = "<?php echo $page; ?>" />
<input type = "hidden" class = "total_record" value = "<?php echo $total_record; ?>" />
<input type = "hidden" class = "perpage_record" value = "<?php echo $perpage; ?>" />
<?php 
if (count($total_record) > 0) {
    $feed_counter = 1;
    foreach ($artistic_post as $row) {
    $userid = $this->session->userdata('aileenuser');
    
    $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => '1'))->row()->art_user_image;
   /* $userfn = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => '1'))->row()->art_name;
    $userln = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => '1'))->row()->art_lastname;
    $slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['user_id'], 'status' => '1'))->row()->slug;*/

    $userimageposted = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_user_image;
    
    $posted_user_url = $this->artistic_model->get_url($row['posted_user_id']);
    $user_url = $this->artistic_model->get_url($row['user_id']);
    /*$userimagefn = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => '1'))->row()->art_name;
    $userimageln = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => '1'))->row()->art_lastname;
    $userslug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $row['posted_user_id'], 'status' => '1'))->row()->slug;*/
    ?>
        <div id="removepost<?php echo $row['art_post_id']; ?>">
            <div class="col-md-12 col-sm-12 post-design-box">
                <div  class="post_radius_box">  
                    <div class="post-design-top col-md-12" >  
                        <div class="post-design-pro-img">
                            <?php if ($row['posted_user_id']) {?>
                                    <a href="<?php echo base_url('artist/p/' . $posted_user_url); ?>">
                                        <?php 
                                        if ($userimageposted) { ?>
                                            <img src = "<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $userimageposted; ?>" alt = "<?php echo $userimageposted; ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOARTIMAGE); ?>';">
                                        <?php
                                        }
                                        else
                                        { ?>
                                            <img src = "<?php echo NOARTIMAGE; ?>" alt = "NOARTIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOARTIMAGE); ?>';">
                                        <?php 
                                        } ?>
                                    </a>
                                <?php
                                }
                                else
                                { ?>
                                    <a href="<?php echo base_url('artist/p/' . $user_url); ?>">
                                        <?php 
                                        if ($art_userimage) { ?>
                                            <img src = "<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" alt = "<?php echo $art_userimage; ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOARTIMAGE); ?>';">
                                        <?php
                                        }
                                        else
                                        { ?>
                                            <img src = "<?php echo NOARTIMAGE; ?>" alt = "NOARTIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOARTIMAGE); ?>';">
                                        <?php 
                                        } ?>
                                    </a>
                                    <?php
                                } ?>
                        </div>
                        <div class="post-design-name fl col-xs-8 col-md-10">
                            <?php

                            $firstname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_name;
                            $lastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['user_id']))->row()->art_lastname;

                            $firstnameposted = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                            $lastnameposted = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;

                            $designation = $row['designation'];

                            $userskill = $row['art_skill'];

                            $aud = $userskill;
                            $aud_res = explode(',', $aud);
                            foreach ($aud_res as $skill) {

                                $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                                $skill1[] = $cache_time;
                            }
                            $listFinal = implode(', ', $skill1);
                            $firstnameposted = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_name;
                            $lastnameposted = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $row['posted_user_id']))->row()->art_lastname;
                            ?>
                            <ul>
                                <li></li>
                                <li>
                                    <?php if ($row['posted_user_id']) { ?>
                                        <div class="else_post_d">
                                            <div class="post-design-product">
                                                <a class="post_dot" href="<?php echo base_url('artist/p/' . $posted_user_url); ?>"><?php echo ucfirst(strtolower($firstnameposted)) . ' ' . ucfirst(strtolower($lastnameposted)); ?></a>
                                                <p class="posted_with" > Posted With</p>
                                                <a class="post_dot1 padding_less_left"  href="<?php echo  base_url('artist/p/' . $user_url);?>">
                                                    <?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>
                                                </a>
                                                <span role="presentation" aria-hidden="true"> · </span>
                                                <span class="ctre_date">
                                                    <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))); ?>
                                                </span>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else{ ?>
                                    <div class="post-design-product">
                                        <a class="post_dot"  href="<?php echo  base_url('artist/p/' . $user_url);?>" title="<?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>">
                                            <?php echo ucfirst(strtolower($firstname)) . ' ' . ucfirst(strtolower($lastname)); ?>
                                        </a>
                                        <span role="presentation" aria-hidden="true"> · </span>
                                        <div class="datespan">
                                            <span class="ctre_date" >
                                                <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($row['created_date']))); ?>
                                            </span>
                                        </div>

                                    </div>
                                    <?php } ?>
                                </li>
                                <li>
                                    <div class="post-design-product">
                                        <a class="buuis_desc_a" href="javascript:void(0);"  title="Designation"><?php
                                            if ($designation) {
                                                echo ucfirst(strtolower($designation));
                                            } else {
                                                echo 'Current Work';
                                            }
                                            ?>
                                        </a>
                                    </div>
                                </li>
                                <li></li> 
                            </ul> 
                        </div>  
                        <div class="dropdown2">
                            <a  onClick="myFunction1(<?php echo $row['art_post_id']; ?>)" class=" dropbtn2 fa fa-ellipsis-v">
                            </a>
                            <div id="myDropdown<?php echo $row['art_post_id']; ?>" class="dropdown-content2 ">
                            <?php
                                if ($row['posted_user_id'] != '0') {
                                    if ($this->session->userdata('aileenuser') == $row['posted_user_id']) {
                                        ?>
                                        <a onclick="deleteownpostmodel(<?php echo $row['art_post_id']; ?>)">
                                            <span class="h4-img h2-srrt"></span> Delete Post
                                        </a>
                                        <a id="<?php echo $row['art_post_id']; ?>" onClick="editpost(this.id)">
                                            <span class="h3-img h2-srrt"></span>Edit
                                        </a>
                                    <?php
                                    } else {
                                        ?>
                                        <a onclick="deleteownpostmodel(<?php echo $row['art_post_id']; ?>)">
                                            <span class="h4-img h2-srrt"></span> Delete Post
                                        </a>
                                        <?php
                                    }
                                } else {
                                    if ($this->session->userdata('aileenuser') == $row['user_id']) {
                                        ?>
                                        <a onclick="deleteownpostmodel(<?php echo $row['art_post_id']; ?>)">
                                            <span class="h4-img h2-srrt"></span> Delete Post
                                        </a>
                                        <a id="<?php echo $row['art_post_id']; ?>" onClick="editpost(this.id)">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit
                                            </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a onclick="deletepostmodel(<?php echo $row['art_post_id']; ?>)">
                                            <span class="h4-img h2-srrt"></span> Delete Post
                                        </a>
                                        <?php
                                    }
                                }
                            ?>
                            </div>
                        </div>
                        <div class="post-design-desc">
                            <div class="ft-15 t_artd">
                                <div id="editpostdata<?php echo $row['art_post_id']; ?>" style="display:block;">
                                    <a id="editpostval<?php echo $row['art_post_id']; ?>">
                                        <?php echo $this->common->make_links($row['art_post']); ?>
                                    </a>
                                </div>
                                <div id="editpostbox<?php echo $row['art_post_id']; ?>" style="display:none;">
                                    <input type="text" class="my_text" id="editpostname<?php echo $row['art_post_id']; ?>" name="editpostname" placeholder="Product Name" value="test" onKeyDown="check_lengthedit(<?php echo $row['art_post_id']; ?>);" onKeyup="check_lengthedit(<?php echo $row['art_post_id']; ?>);" onblur="check_lengthedit(<?php echo $row['art_post_id']; ?>);">
                                    <?php
                                    if ($row['art_post']) {
                                        $counter = $row['art_post'];
                                        $a = strlen($counter);?>
                                        <input size=1 id="text_num" class="text_num" tabindex="-500" value="<?php echo (50 - $a); ?>" name="text_num" disabled="disabled">
                                    <?php
                                    } else {?>
                                        <input size=1 id="text_num" class="text_num" tabindex="-501" value="50" name="text_num" disabled="disabled"><?php
                                    } ?>
                                </div>
                            </div>                    
                            <div id="khyati<?php echo $row['art_post_id']; ?>" style="display:block;">
                            <?php
                                $num_words = 29;
                                $words = array();
                                $words = explode(" ", $row['art_description'], $num_words);
                                $shown_string = "";

                                if (count($words) == 29) {
                                $words[28] = '... <span id="kkkk" onClick="khdiv(' . $row['art_post_id'] . ')">View More</span>';
                                }

                                $shown_string = implode(" ", $words);
                                echo $this->common->make_links($shown_string);
                            ?>
                            </div>
                            <div id="khyatii<?php echo $row['art_post_id']; ?>" style="display:none;">
                                <?php echo $this->common->make_links($row['art_description']); ?>
                            </div>
                            <div id="editpostdetailbox<?php echo $row['art_post_id']; ?>" style="display:none;">
                                <div contenteditable="true" id="editpostdesc<?php echo $row['art_post_id']; ?>"  class="textbuis editable_text margin_btm" name="editpostdesc" placeholder="Description" onpaste="OnPaste_StripFormatting(this, event);" onfocus="return cursorpointer(<?php echo $row['art_post_id']; ?>);">
                                </div>
                            </div>
                            <button class="fr" id="editpostsubmit<?php echo $row['art_post_id']; ?>" style="display:none; margin-right: 5px; border-radius: 3px;" onClick="edit_postinsert(<?php echo $row['art_post_id']; ?>)">Save
                            </button>
                        </div> 
                    </div>
                    <div class="post-design-mid col-md-12" >
                        <div>

                            <?php
                            $contition_array = array('post_id' => $row['art_post_id'], 'is_deleted' => '1', 'insert_profile' => '1');
                            $artmultiimage = $this->data['artmultiimage'] = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            if (count($artmultiimage) == 1) {

                                $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                                $allowespdf = array('pdf');
                                $allowesvideo = array('mp4', 'webm', 'MP4');
                                $allowesaudio = array('mp3');
                                $filename = $artmultiimage[0]['file_name'];
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                if (in_array($ext, $allowed)) { ?>

                                    <div class="one-image">
                                        <a href="<?php echo base_url('artist/post-detail/' . $row['art_post_id']);?>">
                                            <img src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name']?>" alt="<?php echo $artmultiimage[0]['file_name']?>">
                                        </a>
                                    </div>
                                <?php
                                } elseif (in_array($ext, $allowespdf)) {?>
                                    <div>
                                        <a title = "click to open" href = "<?php echo base_url('artist/pdf-view/' . $row['art_post_id']); ?>" target="_blank">
                                            <div class = "pdf_img">
                                                <img src="<?php echo base_url('assets/images/PDF.jpg'); ?>" alt="PDF">
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                } elseif (in_array($ext, $allowesvideo)) {

                                    $post_poster = $artmultiimage[0]['file_name'];
                                    $post_poster1 = explode('.', $post_poster);
                                    $post_poster2 = end($post_poster1);
                                    $post_poster = str_replace($post_poster2, 'png', $post_poster);

                                    if (IMAGEPATHFROM == 'upload') {?>
                                        <div><?php
                                        if (file_exists(ART_POST_MAIN_UPLOAD_URL . $post_poster)) { ?>
                                            <video width = "100%" height = "350" controls poster="<?php echo ART_POST_MAIN_UPLOAD_URL . $post_poster; ?>" id="show_video<?php echo $artmultiimage[0]['post_files_id']; ?>" onplay="playtime(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id']; ?>)" onClick="count_videouser(<?php echo  $artmultiimage[0]['post_files_id'].','.$row['art_post_id'];?>);">
                                        <?php
                                        } else { ?> 
                                            <video width = "100%" height = "350" controls id="show_video<?php echo $artmultiimage[0]['post_files_id']?>" onplay="playtime(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id'];?>)" onClick="count_videouser(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id'];?>);">
                                        <?php
                                        } ?>
                                                <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL.$artmultiimage[0]['file_name']; ?>" type = "video/mp4">
                                                <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name']; ?>" type = "video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <?php
                                    } else { ?>
                                        <div>
                                        <?php
                                        $filename = $this->config->item('art_post_main_upload_path') . $artmultiimage[0]['file_name'];
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                        if ($info) {
                                            ?>
                                            <video width = "100%" height = "350" controls poster="<?php echo  ART_POST_MAIN_UPLOAD_URL . $post_poster; ?>" id="show_video<?php echo $artmultiimage[0]['post_files_id']; ?>" onplay="playtime(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id']; ?>)" onClick="count_videouser(<?php echo  $artmultiimage[0]['post_files_id'].','.$row['art_post_id']; ?>);">
                                        <?php
                                        } else { ?>
                                            <video width = "100%" height = "350" controls id="show_video<?php echo $artmultiimage[0]['post_files_id']; ?>" onplay="playtime(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id']; ?>)" onClick="count_videouser(<?php echo $artmultiimage[0]['post_files_id'].','.$row['art_post_id']; ?>);">
                                        <?php
                                        } ?>
                                                <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL.$artmultiimage[0]['file_name']; ?>" type = "video/mp4">
                                                <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL.$artmultiimage[0]['file_name']; ?>" type = "video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    <?php
                                    }
                                } elseif (in_array($ext, $allowesaudio)) {
                                    ?>
                                    <div class="audio_main_div">
                                        <div class="audio_img">
                                            <img src="<?php echo base_url('assets/images/music-icon.png'); ?>" alt="music-icon.png">  
                                        </div>
                                        <div class="audio_source">
                                            <audio controls>
                                            <source src = "<?php echo ART_POST_MAIN_UPLOAD_URL . $artmultiimage[0]['file_name']; ?>" type = "audio/mp3">
                                            <source src="movie.ogg" type="audio/ogg">
                                            Your browser does not support the audio tag.
                                            </audio>
                                        </div>
                                    </div>
                                <?php
                                }
                            } elseif (count($artmultiimage) == 2) {
                                foreach ($artmultiimage as $multiimage) { ?>
                                    <div class="two-images">
                                        <a href="<?php echo base_url('artist/post-detail/'.$row['art_post_id']); ?>">
                                            <img class = "two-columns" src = "<?php echo ART_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                        </a>
                                    </div>
                                <?php
                                }
                            } elseif (count($artmultiimage) == 3) { ?>
                                <div class = "three-image-top" >
                                    <a href = "<?php echo base_url('artist/post-detail/'. $row['art_post_id']); ?> ">
                                        <img class = "three-columns" src = "<?php echo ART_POST_RESIZE4_UPLOAD_URL . $artmultiimage[0]['file_name']; ?> " alt="<?php echo $artmultiimage[0]['file_name']; ?> ">
                                    </a>
                                </div>
                                <div class = "three-image" >
                                    <a href = "<?php echo base_url('artist/post-detail/'. $row['business_profile_post_id']); ?> ">
                                        <img class = "three-columns" src = "<?php echo ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[1]['file_name']; ?> " alt="<?php echo $artmultiimage[1]['file_name']; ?> ">
                                    </a>
                                </div>
                                <div class = "three-image" >
                                    <a href = "<?php echo base_url('artist/post-detail/'. $row['business_profile_post_id']); ?> ">
                                        <img class = "three-columns" src = "<?php echo ART_POST_RESIZE1_UPLOAD_URL . $artmultiimage[2]['file_name']; ?> " alt="<?php echo $artmultiimage[2]['file_name']; ?> ">
                                    </a>
                                </div>
                            <?php
                            } elseif (count($artmultiimage) == 4) {

                                foreach ($artmultiimage as $multiimage) {
                                    ?>
                                    <div class="four-image">
                                        <a href="<?php echo base_url('artist/post-detail/'.$row['art_post_id']); ?>">
                                            <img class = "breakpoint" src = "<?php echo ART_POST_RESIZE2_UPLOAD_URL.$multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                        </a>
                                    </div>
                                <?php
                                }
                            } elseif (count($artmultiimage) > 4) {
                                $i = 0;
                                foreach ($artmultiimage as $multiimage) { ?>
                                    <div class="four-image">
                                        <a href="<?php echo base_url('artist/post-detail/'.$row['art_post_id']); ?>">
                                           
                                            <img src = "<?php echo ART_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                        </a>
                                    </div>
                                    <?php
                                    $i++;
                                    if ($i == 3)
                                        break;
                                }
                                ?>
                                    <div class="four-image">
                                        <a href="<?php echo base_url('artist/post-detail/'.$row['art_post_id']); ?>">                                            
                                            <img src = "<?php echo ART_POST_RESIZE2_UPLOAD_URL.$artmultiimage[3]['file_name']; ?>" alt="<?php echo $artmultiimage[3]['file_name']; ?>">
                                        </a>
                                        <a class="text-center" href="<?php echo base_url('artist/post-detail/' . $row['art_post_id']); ?>" >
                                            <div class="more-image" >
                                                <span>View All (+ <?php echo (count($artmultiimage) - 4); ?>)</span>
                                            </div>
                                        </a>
                                    </div>
                            <?php
                            }
                            ?>                            
                            <div></div>
                        </div>
                    </div>
                    <div class="post-design-like-box col-md-12">
                        <div class="post-design-menu">
                            <ul class="col-md-6">
                                <li class="likepost<?php echo $row['art_post_id']; ?>">
                                    <a id="<?php echo $row['art_post_id']; ?>" class="ripple like_h_w"  onClick="post_like(this.id)">
                                        <?php
                                        $userid = $this->session->userdata('aileenuser');
                                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                                        $artlike = $this->data['artlike'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        $likeuserarray = explode(',', $artlike[0]['art_like_user']);
                                        if (!in_array($userid, $likeuserarray)) {
                                            ?>
                                            <i class="fa fa-thumbs-up fa-1x" aria-hidden="true"></i>
                                        <?php
                                        } else { ?>
                                            <i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i><?php
                                        } ?>
                                        <span></span>
                                    </a>
                                </li>
                                <li id="insertcount<?php echo $row['art_post_id']; ?>" style="visibility:show">
                                    <a onClick = "commentall(this.id)" id = "<?php echo $row['art_post_id']; ?>" class = "ripple like_h_w">
                                        <i class = "fa fa-comment-o" aria-hidden = "true"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class = "col-md-6 like_cmnt_count">
                                <?php
                                $contition_array = array('post_id' => $row['art_post_id'], 'insert_profile' => '1');
                                $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                //echo "<pre>"; print_r($postformat); die();
                                if ($postformat[0]['post_format'] == 'video') { ?>
                                    <li id="viewvideouser' . $row['art_post_id'] . '">
                                    <?php
                                    $contition_array = array('post_id' => $row['art_post_id'], 'insert_profile' => '1');
                                    $userdata = $this->common->select_data_by_condition('showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                    $user_data = count($userdata);
                                    
                                    if ($user_data > 0) { ?>
                                        <div class="comnt_count_ext_a  comnt_count_ext2">
                                            <span>
                                                <?php echo $user_data. ' '. 'Views'; ?>
                                            </span>
                                        </div>
                                    <?php
                                    } ?>
                                    </li>
                                <?php
                                } 
                                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                                $commnetcount = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                ?>
                                <li>
                                    <div class = "like_cmmt_space comnt_count_ext_a like_count_ext<?php echo $row['art_post_id']; ?>">
                                        <span class = "comment_count" onclick="commentall(<?php echo $row['art_post_id']; ?>)">
                                            <?php
                                            if (count($commnetcount) > 0) {
                                                echo count($commnetcount).' <span> Comment</span>';
                                            }
                                            ?>                                            
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="comnt_count_ext_a  comnt_count_ext<?php echo $row['art_post_id']; ?>">
                                        <span class="comment_like_count" onclick="likeuserlist(<?php echo $row['art_post_id']; ?>)">
                                            <?php
                                            if ($row['art_likes_count'] > 0) {
                                                echo $row['art_likes_count'].' <span> Like</span>';
                                            }
                                            ?>                                            
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    if ($row['art_likes_count'] > 0) {?>

                        <div class="likeduserlist<?php echo $row['art_post_id']; ?>">
                        <?php
                        /*$contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        foreach ($likelistarray as $key => $value) {
                            $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                            $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                        }

                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');*/

                        $likeuser = $row['art_like_user'];
                        $countlike = $row['art_likes_count'] - 1;

                        $likelistarray = explode(',', $likeuser);
                        $likelistarray = array_reverse($likelistarray);

                        $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                        $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname;
                        ?>

                            <div class="like_one_other">
                                <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $row['art_post_id']; ?>)">
                                    <?php
                                    if (in_array($userid, $likelistarray)) {
                                        echo "You";
                                    } else {
                                        echo ucfirst(strtolower($art_fname))." ".ucfirst(strtolower($art_lname));
                                    }
                                    if (count($likelistarray) > 1) {
                                        echo " and ".$countlike." others";
                                    }
                                ?>
                                </a>
                            </div>                            
                        </div>
                    <?php
                    }
                    ?>

                    <div class="likeusername<?php echo $row['art_post_id']; ?>" id="likeusername<?php echo $row['art_post_id']; ?>" style="display:none">
                        <?php
                        $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                        $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        $likeuser = $commnetcount[0]['art_like_user'];
                        $countlike = $commnetcount[0]['art_likes_count'] - 1;
                        $likelistarray = explode(',', $likeuser);

                        foreach ($likelistarray as $key => $value) {
                            $art_fname1 = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_name;
                            $art_lname1 = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row()->art_lastname;
                        }
                        ?>
                        <a href="javascript:void(0);"  onclick="likeuserlist(<?php echo $row['art_post_id']; ?>)">
                            <?php
                            $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1', 'is_delete' => '0');
                            $commnetcount = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                            $likeuser = $commnetcount[0]['art_like_user'];
                            $countlike = $commnetcount[0]['art_likes_count'] - 1;

                            $likelistarray = explode(',', $likeuser);
                            $likelistarray = array_reverse($likelistarray);

                            $art_fname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_name;
                            $art_lname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->art_lastname; ?>
                            <div class="like_one_other">
                                <?php 
                                echo ucfirst(strtolower($art_fname))." ".ucfirst(strtolower($art_lname));
                                if (count($likelistarray) > 1) {
                                    echo " and ".$countlike." others";
                                } ?>
                            </div>
                        </a>
                    </div>

                    <div class="art-all-comment col-md-12">
                        <div  id="fourcomment<?php echo $row['art_post_id']; ?>" style="display:none;"></div>
                        <div id="threecomment<?php echo $row['art_post_id']; ?>" style="display:block">
                            <div class="hidebottomborder insertcomment<?php echo $row['art_post_id']; ?>">
                                <?php 
                                $contition_array = array('art_post_id' => $row['art_post_id'], 'status' => '1');
                                $artdata = $this->data['artdata'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = 'artistic_post_comment_id', $orderby = 'DESC', $limit = '1', $offset = '', $join_str = array(), $groupby = '');
                                if ($artdata) {
                                    foreach ($artdata as $rowdata) {
                                        $artname = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_name;
                                        $artlastname = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->art_lastname;
                                        $artslug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $rowdata['user_id']))->row()->slug;

                                        $geturl = $this->artistic_model->get_url($rowdata['user_id']);?>
                                        <div class="all-comment-comment-box">
                                        <div class="post-design-pro-comment-img">
                                        <a href="' . base_url('artist/p/' . $geturl) . '">
                                        <?php
                                        $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $rowdata['user_id'], 'status' => '1'))->row()->art_user_image;

                                        if (IMAGEPATHFROM == 'upload') {
                                            if ($art_userimage) {
                                                if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {
                                                    ?>
                                                        <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE">
                                                    <?php
                                                } else { ?>
                                                    <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" alt="<?php echo $art_userimage; ?>">
                                                    <?php
                                                }
                                            } else {?>
                                                <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE"><?php
                                            }
                                        } else {

                                            $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                            $s3 = new S3(awsAccessKey, awsSecretKey);
                                            $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                                            if ($info) { ?>
                                                <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                            <?php
                                            } else { ?>
                                                <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE">
                                            <?php
                                            }
                                        }
                                        ?>
                                        </a>
                                        </div>
                                        <div class="comment-name">
                                        <a href="<?php echo base_url('artist/p/' . $geturl); ?>">
                                            <b title="<?php echo ucfirst(strtolower($artname)).' '.ucfirst(strtolower($artlastname));?>">
                                                <?php echo ucfirst(strtolower($artname)).' '.ucfirst(strtolower($artlastname)); ?>
                                            </b>
                                        </a>
                                        </div>
                                        <div class="comment-details" id="showcomment<?php echo  $rowdata['artistic_post_comment_id']; ?>">

                                        <div id="lessmore<?php echo $rowdata['artistic_post_comment_id']; ?>" style="display:block;">
                                        <?php
                                        $small = substr($rowdata['comments'], 0, 180);
                                        echo $this->common->make_links($small);

                                        if (strlen($rowdata['comments']) > 180) { ?>
                                            ... <span id="kkkk" onClick="seemorediv(<?php echo $rowdata['artistic_post_comment_id']; ?>)">view More</span>
                                        <?php 
                                        } ?>
                                        </div>
                                        <div id="seemore<?php echo $rowdata['artistic_post_comment_id']; ?>" style="display:none;">
                                            <?php
                                            $new_product_comment = $this->common->make_links($rowdata['comments']);
                                            echo nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                            ?>
                                        </div>
                                        </div>
                                        <div class="edit-comment-box">
                                            <div class="inputtype-edit-comment">
                                                <div contenteditable="true" style="display:none" class="editable_text editav_2 custom-edit" name="<?php echo $rowdata['artistic_post_comment_id']; ?>"  id="editcomment<?php echo $rowdata['artistic_post_comment_id']; ?>" placeholder="Enter Your Comment " value= ""  onkeyup="commentedit(<?php echo $rowdata['artistic_post_comment_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);">' . $rowdata['comments'] . '</div>
                                                <span class="comment-edit-button"><button id="editsubmit<?php echo $rowdata['artistic_post_comment_id']; ?>" style="display:none" onClick="edit_comment(<?php echo $rowdata['artistic_post_comment_id']; ?>)">Save</button></span>
                                            </div>
                                        </div>
                                        <div class="art-comment-menu-design"> 
                                            <div class="comment-details-menu" id="likecomment1<?php echo $rowdata['artistic_post_comment_id']; ?>">
                                                <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_like1(this.id)">
                                        <?php
                                        $userid = $this->session->userdata('aileenuser');
                                        $contition_array = array('artistic_post_comment_id' => $rowdata['artistic_post_comment_id'], 'status' => '1');
                                        $artcommentlike = $this->data['artcommentlike'] = $this->common->select_data_by_condition('artistic_post_comment', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                        $likeuserarray = explode(',', $artcommentlike[0]['artistic_comment_like_user']);
                                        if (!in_array($userid, $likeuserarray)) {?>
                                            <i class="fa fa-thumbs-up fa-1x"  aria-hidden="true"></i>
                                            <?php
                                        } else { ?>
                                            <i class="fa fa-thumbs-up fa-1x main_color" aria-hidden="true"></i><?php
                                        } ?>
                                        <span>
                                        <?php
                                        if ($rowdata['artistic_comment_likes_count']) {
                                            echo $rowdata['artistic_comment_likes_count'];
                                        } ?>
                                        </span>
                                        </a>
                                        </div>
                                        <?php
                                        $userid = $this->session->userdata('aileenuser');
                                        if ($rowdata['user_id'] == $userid) { ?>
                                            <span role="presentation" aria-hidden="true"> · 
                                            </span>
                                            <div class="comment-details-menu">
                                            <div id="editcommentbox<?php echo $rowdata['artistic_post_comment_id']; ?>" style="display:block;">
                                            <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>"   onClick="comment_editbox(this.id)" class="editbox">Edit
                                            </a>
                                            </div>
                                            <div id="editcancle<?php echo $rowdata['artistic_post_comment_id']; ?>" style="display:none;">
                                            <a id="<?php echo $rowdata['artistic_post_comment_id']; ?>" onClick="comment_editcancle(this.id)">Cancel
                                            </a>
                                            </div>
                                            </div>
                                            <?php
                                        }
                                        $userid = $this->session->userdata('aileenuser');
                                        $art_userid = $this->db->select('user_id')->get_where('art_post', array('art_post_id' => $rowdata['art_post_id'], 'status' => '1'))->row()->user_id;
                                        if ($rowdata['user_id'] == $userid || $art_userid == $userid) { ?>
                                            <span role="presentation" aria-hidden="true"> · 
                                            </span>
                                            <div class="comment-details-menu">
                                            <input type="hidden" name="post_delete"  id="post_delete<?php echo  $rowdata['artistic_post_comment_id']; ?>" value= "<?php echo $rowdata['art_post_id']; ?>">
                                            <a id="<?php echo  $rowdata['artistic_post_comment_id']; ?>"   onClick="comment_delete(this.id)"> Delete
                                            <span class="insertcomment<?php echo  $rowdata['artistic_post_comment_id']; ?>">
                                            </span>
                                            </a>
                                            </div>
                                        <?php
                                        } ?>
                                            <span role="presentation" aria-hidden="true"> · 
                                            </span>
                                            <div class="comment-details-menu">
                                            <p>

                                            <?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))); ?>
                                            </p>
                                            </div>
                                            </div>
                                            </div>
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="post-design-commnet-box col-md-12">
                        <div class="post-design-proo-img hidden-mob">
                            <?php
                            $art_slug = $this->db->select('slug')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->slug;
                            ?>
                            <a href="<?php echo base_url('artist/p/' . $art_slug); ?>">
                                <?php
                                $userid = $this->session->userdata('aileenuser');
                                $art_userimage = $this->db->select('art_user_image')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_user_image;

                                $art_fn = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_name;
                                $art_ln = $this->db->select('art_lastname')->get_where('art_reg', array('user_id' => $userid, 'status' => '1'))->row()->art_lastname;

                                if (IMAGEPATHFROM == 'upload') {
                                    if ($art_userimage) {
                                        if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $art_userimage)) {?>
                                            <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE">
                                            <?php
                                        } else { ?>
                                            <img src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>" alt="<?php echo $art_userimage; ?>" >
                                            <?php
                                        }
                                    } else { ?>
                                        <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE">
                                        <?php
                                    }
                                } else {

                                    $filename = $this->config->item('art_profile_thumb_upload_path') . $art_userimage;
                                    $s3 = new S3(awsAccessKey, awsSecretKey);
                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                    if ($info) { ?>
                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $art_userimage; ?>"  alt="<?php echo $art_userimage; ?>">
                                    <?php
                                    } else { ?>
                                        <img src = "<?php echo base_url(NOARTIMAGE); ?>" alt = "NOARTIMAGE">
                                    <?php
                                    }
                                }
                                ?>
                            </a>
                        </div>
                        <div id="content" class="col-md-12  inputtype-comment cmy_2" >
                            <div contenteditable="true" class="edt_2 editable_text" name="<?php echo $row['art_post_id']; ?>"  id="post_comment<?php echo $row['art_post_id']; ?>" placeholder="Add a Comment ..." onClick="entercomment(<?php echo $row['art_post_id']; ?>)" onpaste="OnPaste_StripFormatting(this, event);"></div>
                            <div class="mob-comment">       
                                <button id="<?php echo $row['art_post_id']; ?>" onClick="insert_comment(this.id)">
                                    <img src="<?php echo base_url('assets/img/send.png'); ?>">
                                </button>
                            </div>
                        </div>
                        <div class=" comment-edit-butn hidden-mob" >   
                            <button  id="<?php echo $row['art_post_id']; ?>" onClick="insert_comment(this.id)">Comment</button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if($feed_counter % ADS_BREAK == 0)
        { ?>
            <div class="tab-add"><?php echo $infeed_add; ?></div>
        <?php
        }
        $feed_counter ++;
    }
}
else { ?>
    <div class="art_no_post_avl" id="no_post_avl">
        <h3> Post</h3>
        <div class="art-img-nn">
            <div class="art_no_post_img">
                <img src="<?php echo base_url('assets/img/art-no.png'); ?>" alt="art-no.png">
            </div>
            <div class="art_no_post_text">
                No Post Available.
            </div>
        </div>
    </div><?php
} ?>