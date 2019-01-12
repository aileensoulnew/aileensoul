<input type = "hidden" class = "page_number" value = "<?php echo $page; ?>" />
<input type = "hidden" class = "total_record" value = "<?php echo $business_profile_post_total_rec; ?>" />
<input type = "hidden" class = "perpage_record" value = "<?php echo $perpage; ?>" />
<?php
$userid = $this->session->userdata('aileenuser');
 if ($business_profile_post_total_rec > 0) {
    $feed_counter = 1;
    foreach ($business_profile_post as $row) {
        $post_business_user_image = $row['business_user_image'];
        $post_company_name = $row['company_name'];
        $post_business_profile_post_id = $row['business_profile_post_id'];
        $post_product_name = $row['product_name'];
        //$post_product_image = $row['product_image'];
        $post_product_description = $row['product_description'];
        $post_business_likes_count = $row['business_likes_count'];
        $post_business_like_user = $row['business_like_user'];
        $post_created_date = $row['created_date'];
        $post_posted_user_id = $row['posted_user_id'];
        $slugname = ($row['city_name']) ? $row['city_name'] : $row['state_name'];
        $row['business_slug'] = $row['business_slug']."-".$slugname;
        $post_business_slug = $row['business_slug'];
        $business_login_slug = $post_business_slug;
        $post_industriyal = $row['industriyal'];
        $post_user_id = $row['user_id'];
        $post_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
        $post_other_industrial = $row['other_industrial'];
        if ($post_posted_user_id) {
            $posted_company_name = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->company_name;
            // $posted_business_slug = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id, 'status' => '1'))->row()->business_slug;

            $sql = "SELECT IF (bp.city IS NULL, concat(bp.business_slug, '-', st.state_name) ,concat(bp.business_slug, '-', ct.city_name)) as business_slug
            FROM ailee_business_profile bp
            LEFT JOIN ailee_cities ct on bp.city = ct.city_id
            LEFT JOIN ailee_states st on bp.state = st.state_id
            WHERE bp.status = '1' AND user_id = '". $post_posted_user_id ."'";

            $query = $this->db->query($sql);
            $posted_business_slug = $query->row()->business_slug;

            $posted_category = $this->db->get_where('industry_type', array('industry_id' => $post_industriyal, 'status' => '1'))->row()->industry_name;
            $posted_business_user_image = $this->db->get_where('business_profile', array('user_id' => $post_posted_user_id))->row()->business_user_image;
        }
    ?>
    <div id = "removepost<?php echo $post_business_profile_post_id; ?>">
        <div class = "col-md-12 col-sm-12 post-design-box">
            <div class = "post_radius_box">
                <div class = "post-design-top col-md-12" >
                    <div class = "post-design-pro-img">
                        <div id = "popup1" class = "overlay">
                            <div class = "popup">
                                <div class = "pop_content">
                                    Your Post is Successfully Saved.
                                    <p class = "okk">
                                        <a class = "okbtn" href = "#">Ok</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($post_posted_user_id) { ?>
                            <a href = "<?php echo base_url('company/' . $posted_business_slug) ?>">
                        <?php if ($posted_business_user_image) { ?>                        
                                <img src = "<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $posted_business_user_image ?>" alt = "NOBUSIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';">
                            <?php 
                            }
                            else{ ?>
                                <img src = "<?php echo base_url(NOBUSIMAGE); ?>" alt = "NOBUSIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';">
                            </a>
                        <?php }
                        }
                        else{
                            ?>
                            <a href = "<?php echo base_url('company/' . $post_business_slug) ?>">
                            <?php if ($post_business_user_image) { ?>                        
                                    <img src = "<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $post_business_user_image ?>" alt = "NOBUSIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';">
                                <?php 
                                }
                                else{ ?>
                                    <img src = "<?php echo base_url(NOBUSIMAGE); ?>" alt = "NOBUSIMAGE" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';">
                                </a>
                            <?php }
                        } ?>
                    </div>
                    <div class = "post-design-name fl col-xs-8 col-md-10">
                        <ul>
                            <li></li>
                            <li>
                                <?php
                                if ($post_posted_user_id) { ?>
                                    <div class = "else_post_d">
                                        <div class = "post-design-product">
                                            <a class = "post_dot" href = "<?php echo base_url('company/' . $posted_business_slug);?>">
                                                <?php echo ucfirst(strtolower($posted_company_name));?>
                                            </a>
                                            <p class = "posted_with" > Posted With</p> <a class = "other_name name_business post_dot" href = "<?php echo base_url('company/' . $post_business_slug);?>"><?php echo ucfirst(strtolower($post_company_name));?></a>
                                            <div class = "datespan">
                                                <span class = "ctre_date" ><?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                }
                                else{ ?>
                                    <div class = "post-design-product">
                                        <a class = "post_dot" href = "<?php echo base_url('company/' . $post_business_slug); ?>" title = "<?php echo ucfirst(strtolower($post_company_name)); ?>"><?php echo ucfirst(strtolower($post_company_name)); ?></a>
                                        <div class = "datespan">
                                            <span class = "ctre_date" ><?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_created_date))); ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </li>
                            <li>
                                <div class = "post-design-product">
                                <a class = "buuis_desc_a" href = "javascript:void(0);" title = "Category"><?php 
                                    if ($post_industriyal) {
                                        echo ucfirst(strtolower($post_category));
                                    } else {
                                        echo ucfirst(strtolower($post_other_industrial));
                                    } ?>
                                </a>
                                </div>
                            </li>
                            <li>
                            </li>
                        </ul>
                    </div>
                    <div class = "dropdown1">
                        <a onClick = "myFunction('<?php echo $post_business_profile_post_id ?>')" class = "dropbtn_common  dropbtn1 fa fa-ellipsis-v">
                        </a>
                        <div id = "myDropdown<?php echo $post_business_profile_post_id ?>" class = "dropdown-content1 dropdown2_content">
                            <?php
                            if ($post_posted_user_id != 0) { ?>
                                <a onclick = "user_postdelete(<?php echo $post_business_profile_post_id ?>)"><i class = "fa fa-trash-o" aria-hidden = "true"></i> Delete Post</a>
                                <?php if ($userid == $post_posted_user_id) { ?>
                                <a id = "<?php echo $post_business_profile_post_id ?>" onClick = "editpost(this.id)"><i class = "fa fa-pencil-square-o" aria-hidden = "true"></i>Edit</a>
                            <?php }
                            }
                            else{
                                if ($userid == $post_user_id) { ?>
                                <a onclick = "user_postdelete(<?php echo $post_business_profile_post_id ?>)"><i class = "fa fa-trash-o" aria-hidden = "true"></i> Delete Post</a>
                                <a id = "<?php echo $post_business_profile_post_id ?>" onClick = "editpost(this.id)"><i class = "fa fa-pencil-square-o" aria-hidden = "true"></i>Edit</a>
                            <?php }
                                else{ ?>
                                <a onclick = "user_postdeleteparticular(<?php echo $post_business_profile_post_id ?>)">
                                    <i class = "fa fa-trash-o" aria-hidden = "true"></i> Delete Post
                                </a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                    <div class = "post-design-desc">
                        <div class = "ft-15 t_artd">
                            <div id = "editpostdata<?php echo $post_business_profile_post_id ?>" style = "display:block;">
                                <a><?php echo $this->common->make_links($post_product_name); ?></a>
                            </div>
                            <div id = "editpostbox<?php echo $post_business_profile_post_id ?>" style = "display:none;">
                                <input type = "text" class="productpostname" id = "editpostname<?php echo $post_business_profile_post_id ?>" name = "editpostname" placeholder = "Product Name" value = "<?php echo $post_product_name; ?>" tabindex="<?php echo $post_business_profile_post_id ?>" onKeyDown = check_lengthedit(<?php echo $post_business_profile_post_id ?>);onKeyup = check_lengthedit(<?php echo $post_business_profile_post_id ?>);onblur = check_lengthedit(<?php echo $post_business_profile_post_id ?>);>
                                <?php 
                                if ($post_product_name) {
                                    $counter = $post_product_name;
                                    $a = strlen($counter); ?>
                                    <input size = 1 id = "text_num_<?php echo $post_business_profile_post_id ?>" class = "text_num" value = "<?php echo (50 - $a) ?>" name = "text_num" disabled>
                                <?php }else{
                                    ?>
                                    <input size = 1 id = "text_num_<?php echo $post_business_profile_post_id ?>" class = "text_num" value = "50" name = "text_num" disabled>
                                <?php
                                    } ?>
                            </div>
                        </div>
                        <div id = "khyati<?php echo $post_business_profile_post_id ?>" style = "display:block;">
                        <?php
                            $small = substr($post_product_description, 0, 180);
                            echo nl2br($this->common->make_links($small));
                            if (strlen($post_product_description) > 180) {
                                ?>... <span id = "kkkk" onClick = "khdiv(<?php echo $post_business_profile_post_id ?>)">View More</span><?php
                            } ?>                            
                        </div>
                        <div id = "khyatii<?php echo $post_business_profile_post_id ?>" style = "display:none;"><?php echo $post_product_description; ?></div>
                        <div id = "editpostdetailbox<?php echo $post_business_profile_post_id ?>" style = "display:none;">
                            <div contenteditable = "true" id = "editpostdesc<?php echo $post_business_profile_post_id ?>" class = "textbuis editable_text margin_btm" name = "editpostdesc" placeholder = "Description" tabindex="<?php echo $post_business_profile_post_id + 1; ?>" onpaste = "OnPaste_StripFormatting(this, event);" onfocus="cursorpointer(<?php echo $post_business_profile_post_id ?>)"><?php echo $post_product_description; ?></div>
                        </div>
                        <div id = "editpostdetailbox<?php echo $post_business_profile_post_id ?>" style = "display:none;">
                            <div contenteditable = "true" id = "editpostdesc<?php echo $post_business_profile_post_id ?>" placeholder = "Product Description" class = "textbuis  editable_text" name = "editpostdesc" onpaste = "OnPaste_StripFormatting(this, event);"><?php echo $post_product_description; ?></div>
                        </div>
                        <button class = "fr" id = "editpostsubmit<?php echo $post_business_profile_post_id ?>" style = "display:none;margin: 5px 7px; border-radius: 3px;" onClick = "edit_postinsert(<?php echo $post_business_profile_post_id ?>)">Save</button>
                    </div>
                </div>
                <div class = "post-design-mid col-md-12 padding_adust" >
                    <div><?php
                        $contition_array = array('post_id' => $post_business_profile_post_id, 'is_deleted' => '1', 'insert_profile' => '2');
                        $businessmultiimage = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'file_name,post_files_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        if (count($businessmultiimage) == 1) {

                            $allowed = array('jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg');
                            $allowespdf = array('pdf');
                            $allowesvideo = array('mp4', 'webm', 'qt', 'mov', 'MP4');
                            $allowesaudio = array('mp3');
                            $filename = $businessmultiimage[0]['file_name'];
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if (in_array($ext, $allowed)) { ?>

                                <div class = "one-image">
                                    <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <img src = "<?php echo BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name']; ?>" alt="<?php echo $businessmultiimage[0]['file_name']; ?>">
                                    </a>
                                </div>
                            <?php
                            } elseif (in_array($ext, $allowespdf)) {
                                ?>
                                <div>
                                    <a title = "click to open" href = "<?php echo base_url('business-profile/pdf-view/' . $post_business_profile_post_id); ?>" target="_blank"><div class = "pdf_img">
                                    <img src="<?php echo base_url('assets/images/PDF.jpg'); ?>" alt="PDF.jpg">
                                </div>
                                </a>
                                </div>
                            <?php
                            } elseif (in_array($ext, $allowesvideo)) {
                                $post_poster = $businessmultiimage[0]['file_name'];
                                $post_poster1 = explode('.', $post_poster);
                                $post_poster2 = end($post_poster1);
                                $post_poster = str_replace($post_poster2, 'png', $post_poster); ?>
                                <div>
                                    <video width = "100%" height = "350" poster="<?php echo BUS_POST_MAIN_UPLOAD_URL . $post_poster; ?>" id="show_video<?php echo $businessmultiimage[0]['post_files_id']; ?>" onplay="playtime(<?php echo $businessmultiimage[0]['post_files_id'].','.$post_business_profile_post_id;?>)" onClick="count_videouser( <?php echo $businessmultiimage[0]['post_files_id'].','.$post_business_profile_post_id; ?>);" controls playsinline webkit-playsinline>
                                    <source src = "<?php echo BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name']; ?>" type = "video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                </div><?php
                            } elseif (in_array($ext, $allowesaudio)) { ?>

                                <div class = "audio_main_div">
                                    <div class = "audio_img">
                                        <img src = "<?php echo base_url('assets/images/music-icon.png'); ?>" alt="music-icon.png">
                                    </div>
                                    <div class = "audio_source">
                                        <audio id = "audio_player" width = "100%" height = "100" controls>
                                            <source src = "<?php echo BUS_POST_MAIN_UPLOAD_URL . $businessmultiimage[0]['file_name']; ?>" type = "audio/mp3">
                                            Your browser does not support the audio tag.
                                        </audio>
                                    </div>
                                    <div class = "audio_mp3" id = "postname<?php echo $post_business_profile_post_id; ?>">
                                        <p title = "<?php echo $post_product_name; ?>"><?php echo $post_product_name; ?></p>
                                    </div>
                                </div><?php
                            }
                        } elseif (count($businessmultiimage) == 2) {

                            foreach ($businessmultiimage as $multiimage) { ?>
                                <div class = "two-images">
                                    <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                        <img class = "two-columns" src = "<?php echo BUS_POST_RESIZE1_UPLOAD_URL . $multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                    </a>
                                </div>
                            <?php
                            }
                        } elseif (count($businessmultiimage) == 3) { ?>

                            <div class = "three-image-top" >
                                <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <img class = "three-columns" src = "<?php echo BUS_POST_RESIZE4_UPLOAD_URL . $businessmultiimage[0]['file_name']; ?>" alt="<?php echo $businessmultiimage[0]['file_name']; ?>">
                                </a>
                            </div>
                            <div class = "three-image" >
                                <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <img class = "three-columns" src = "<?php echo BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[1]['file_name']; ?>" alt="<?php echo $businessmultiimage[1]['file_name']; ?>">
                                </a>
                            </div>
                            <div class = "three-image" >
                                <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <img class = "three-columns" src = "<?php echo BUS_POST_RESIZE1_UPLOAD_URL . $businessmultiimage[2]['file_name']; ?>" alt="<?php echo  $businessmultiimage[2]['file_name']; ?>">
                                </a>
                            </div>
                            <?php
                        } elseif (count($businessmultiimage) == 4) {

                            foreach ($businessmultiimage as $multiimage) { ?>

                                <div class = "four-image">
                                    <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                        <img class = "breakpoint" src = "<?php echo BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                    </a>
                                </div>
                            <?php
                            }
                        } elseif (count($businessmultiimage) > 4) {
                            $i = 0;
                            foreach ($businessmultiimage as $multiimage) { ?>

                                <div class = "four-image">
                                    <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                        <img src = "<?php echo BUS_POST_RESIZE2_UPLOAD_URL . $multiimage['file_name']; ?>" alt="<?php echo $multiimage['file_name']; ?>">
                                    </a>
                                </div>
                                <?php

                                $i++;
                                if ($i == 3)
                                    break;
                            } ?>

                            <div class = "four-image">
                                <a href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <img src = "<?php echo BUS_POST_RESIZE2_UPLOAD_URL . $businessmultiimage[3]['file_name']; ?>" alt="<?php echo $businessmultiimage[3]['file_name']; ?>">
                                </a>
                                <a class = "text-center" href = "<?php echo base_url('company/' . $business_login_slug . '/post/' . $post_business_profile_post_id); ?>">
                                    <div class = "more-image" >
                                        <span>View All (+<?php echo count($businessmultiimage) - 4?>)</span>
                                    </div>
                                </a>
                            </div><?php
                        } ?>

                        <div></div>
                    </div>
                </div>
                <div class = "post-design-like-box col-md-12">
                    <div class = "post-design-menu">
                        <ul class = "col-md-6 col-sm-6 col-xs-6">
                            <li class = "likepost<?php echo $post_business_profile_post_id ?>">
                                <a id = "<?php echo $post_business_profile_post_id ?>" class = "ripple like_h_w" onClick = "post_like(this.id)"><?php
                                    $likeuser = $post_business_like_user;
                                    $likeuserarray = explode(',', $likeuser);
                                    if (!in_array($userid, $likeuserarray)) { ?>
                                        <i class = "fa fa-thumbs-up fa-1x" aria-hidden = "true"></i>
                                        <?php
                                    } else { ?>
                                        <i class = "fa fa-thumbs-up fa-1x main_color" aria-hidden = "true"></i><?php
                                    } ?>
                                    <span class = "like_As_count">
                                        <?php
                                        if ($post_business_likes_count > 0) {
                                            echo $post_business_likes_count;
                                        } ?>
                                    </span>
                                </a>
                            </li>
                            <li id = "insertcount<?php echo $post_business_profile_post_id ?>" style = "visibility:show">
                                <?php 
                                $commnetcount = $this->business_model->getBusinessPostComment($post_id = $post_business_profile_post_id, $sortby = '', $orderby = '', $limit = '');
                                ?>
                                <a onClick = "commentall(this.id)" id = "<?php echo $post_business_profile_post_id ?>" class = "ripple like_h_w"><i class = "fa fa-comment-o" aria-hidden = "true"></i></a>
                            </li>
                        </ul>
                        <ul class = "col-md-6 col-sm-6 col-xs-6 like_cmnt_count">
                            <?php
                            $contition_array = array('post_id' => $row['business_profile_post_id'], 'insert_profile' => '2');
                            $postformat = $this->common->select_data_by_condition('post_files', $contition_array, $data = 'post_format', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($postformat[0]['post_format'] == 'video') { ?>
                                <li id="viewvideouser<?php echo $row['business_profile_post_id']; ?>">
                                <?php
                                $contition_array = array('post_id' => $row['business_profile_post_id']);
                                $userdata = $this->common->select_data_by_condition('bus_showvideo', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                $user_data = count($userdata);

                                if ($user_data > 0) { ?>
                                    <div class="comnt_count_ext_a  comnt_count_ext2"><span>
                                    <?php echo $user_data." Views"; ?> 
                                    </span></div></li>
                                <?php
                                }
                            } ?>
                            <li>
                                <div class = "like_count_ext" onClick = "commentall(<?php echo $post_business_profile_post_id ?>)">
                                    <span class = "comment_count<?php echo $post_business_profile_post_id ?>" ><?php
                                        if (count($commnetcount) > 0) {
                                            echo count($commnetcount);?>
                                            <span> Comment</span><?php
                                        } ?>                                        
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div class = "comnt_count_ext">
                                    <span class = "comment_like_count<?php echo $post_business_profile_post_id ?>" onclick = "likeuserlist(<?php echo $post_business_profile_post_id ?>)"><?php
                                        if ($post_business_likes_count > 0) {
                                            echo $post_business_likes_count; ?>
                                            <span> Like</span><?php
                                        } ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                if ($post_business_likes_count > 0) { ?>
                <div class = "likeduserlist<?php echo $post_business_profile_post_id; ?>">
                    <?php
                    $likeuser = $post_business_like_user;
                    $countlike = $post_business_likes_count - 1;
                    $likelistarray = explode(',', $likeuser); ?>
                    <div class = "like_one_other">
                        <a href = "javascript:void(0);" onclick = "likeuserlist(<?php echo $post_business_profile_post_id; ?>)">
                            <?php
                            $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $likelistarray[0], 'status' => '1'))->row()->company_name;

                            if (in_array($userid, $likelistarray)) {
                                echo "You ";
                            }
                            else{
                                echo ucfirst($business_fname1);
                            }
                            if (count($likelistarray) > 1) {
                                echo " and ".$countlike." others";
                            } ?>
                        </a>
                    </div>
                </div>
                <?php } ?>
                
                <div class = "likeusername<?php echo $post_business_profile_post_id ?>" id = "likeusername<?php echo $post_business_profile_post_id ?>" style = "display:none">
                    <?php
                    $likeuser = $post_business_like_user;
                    $countlike = $post_business_likes_count - 1;
                    $likelistarray = explode(', ', $likeuser);


                    $likeuser = $post_business_like_user;
                    $countlike = $post_business_likes_count - 1;
                    $likelistarray = explode(', ', $likeuser);

                    $business_fname1 = $this->db->get_where('business_profile', array('user_id' => $value, 'status' => '1'))->row()->company_name; ?>
                    <div class = "like_one_other">
                        <a href = "javascript:void(0);" onclick = "likeuserlist(<?php echo $post_business_profile_post_id; ?>)">
                        <?php echo ucfirst($business_fname1);
                        if (count($likelistarray) > 1) {
                            echo " and ".$countlike." others";
                        } ?>
                        </a>
                    </div>                    
                </div>
                <div class = "art-all-comment col-md-12">
                    <div id = "fourcomment<?php echo $post_business_profile_post_id ?>" style = "display:none;"></div>
                    <div id = "threecomment<?php echo $post_business_profile_post_id ?>" style = "display:block">
                        <div class = "hidebottomborder insertcomment<?php echo $post_business_profile_post_id ?>">
                            <?php $businessprofiledata = $this->data['businessprofiledata'] = $this->business_model->getBusinessPostComment($post_id = $post_business_profile_post_id, $sortby = 'business_profile_post_comment_id', $orderby = 'DESC', $limit = '1');
                                if ($businessprofiledata) {
                                foreach ($businessprofiledata as $rowdata) {                                
                                    $likeuser_cmt = $rowdata['business_comment_like_user'];
                                    $cmt_likeuserarray = explode(',', $likeuser_cmt); ?>
                                    <div class = "all-comment-comment-box">
                                        <div class = "post-design-pro-comment-img">
                                            <a href = "<?php echo base_url().'company/'.$rowdata['business_slug']; ?>">
                                                <?php 
                                                if($rowdata['business_user_image'] != ''){ ?>
                                                    <img src = "<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $rowdata['business_user_image']; ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';" alt = "NOBUSIMAGE">
                                                <?php 
                                                }
                                                else{ ?>
                                                    <img src = "<?php echo base_url(NOBUSIMAGE); ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';" alt = "NOBUSIMAGE">
                                                <?php     
                                                } ?>
                                            </a>
                                        </div>
                                        <div class = "comment-name">
                                            <a href="<?php echo base_url().'company/'.$rowdata['business_slug']; ?>" title = "Universal Technologies Pvt. Ltd.">
                                                <b><?php echo $rowdata['company_name']; ?></b>
                                            </a>
                                        </div>
                                        <div class = "comment-details" id = "showcomment<?php echo $rowdata['business_profile_post_comment_id']; ?>">
                                            <div id = "lessmore<?php echo $rowdata['business_profile_post_comment_id']; ?>" style = "display:block;">
                                                <?php 
                                                    $small = substr($rowdata['comments'], 0, 180);
                                                    echo nl2br($this->common->make_links($small));
                                                    if (strlen($rowdata['comments']) > 180) { ?>
                                                        ...<span id = "kkkk" onClick = "seemorediv(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">See More</span>
                                                    <?php
                                                    }
                                                ?>
                                            </div>
                                            <div id = "seemore<?php echo $rowdata['business_profile_post_comment_id']; ?>" style = "display:none;">
                                                <?php
                                                    $new_product_comment = $this->common->make_links($rowdata['comments']);
                                                    echo nl2br(htmlspecialchars_decode(htmlentities($new_product_comment, ENT_QUOTES, 'UTF-8')));
                                                ?>
                                            </div>
                                        </div>
                                        <div class = "edit-comment-box">
                                            <div class = "inputtype-edit-comment">
                                                <div contenteditable = "true" class = "editable_text editav_2" name = "<?php echo $rowdata['business_profile_post_comment_id']; ?>" id = "editcomment<?php echo $rowdata['business_profile_post_comment_id']; ?>" placeholder = "Enter Your Comment " value = "" onkeyup = "commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)" onclick="commentedit(<?php echo $rowdata['business_profile_post_comment_id']; ?>)" onpaste = "OnPaste_StripFormatting(this, event);">
                                                    sss
                                                </div>
                                                <span class = "comment-edit-button">
                                                    <button id = "editsubmit<?php echo $rowdata['business_profile_post_comment_id']; ?>" style = "display:none" onClick = "edit_comment(<?php echo $rowdata['business_profile_post_comment_id']; ?>)">Save</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class = "art-comment-menu-design">
                                            <div class = "comment-details-menu" id = "likecomment1<?php echo $rowdata['business_profile_post_comment_id']; ?>">
                                                <a id = "<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick = "comment_like1(this.id)">
                                                    <?php
                                                    if (!in_array($userid, $cmt_likeuserarray)) { ?>
                                                        <i class = "fa fa-thumbs-up" style = "color: #999;" aria-hidden = "true"></i> <?php
                                                    } else { ?>
                                                        <i class = "fa fa-thumbs-up main_color" aria-hidden = "true"></i><?php
                                                    } ?>                                            
                                                    <span>
                                                        <?php
                                                        if ($rowdata['business_comment_likes_count']) {
                                                            echo $rowdata['business_comment_likes_count'];
                                                        } ?>
                                                    </span>
                                                </a>
                                            </div>
                                            <?php
                                            if ($rowdata['user_id'] == $userid) { ?>
                                                <span role = "presentation" aria-hidden = "true"> · </span>
                                                <div class = "comment-details-menu">
                                                    <div id = "editcommentbox<?php echo $rowdata['business_profile_post_comment_id']; ?>" style = "display:block;">
                                                        <a id = "<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick = "comment_editbox(this.id)" class = "editbox">Edit</a>
                                                    </div>
                                                    <div id = "editcancle<?php echo $rowdata['business_profile_post_comment_id']; ?>" style = "display:none;">
                                                        <a id = "<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick = "comment_editcancle(this.id)">Cancel</a>
                                                    </div>
                                                </div>
                                            <?php
                                            } 

                                            $business_userid = $this->db->get_where('business_profile_post', array('business_profile_post_id' => $rowdata['business_profile_post_id'], 'status' => '1'))->row()->user_id;
                                            if ($rowdata['user_id'] == $userid || $business_userid == $userid) { ?>
                                                <span role = "presentation" aria-hidden = "true"> · </span>
                                                <div class = "comment-details-menu">
                                                    <input type = "hidden" name = "post_delete" id = "post_delete<?php echo $rowdata['business_profile_post_comment_id']; ?>" value = "<?php echo $rowdata['business_profile_post_comment_id']; ?>">
                                                    <a id = "<?php echo $rowdata['business_profile_post_comment_id']; ?>" onClick = "comment_delete(this.id)"> Delete
                                                        <span class = "insertcomment<?php echo $rowdata['business_profile_post_comment_id']; ?>"></span>
                                                    </a>
                                                </div>
                                            <?php
                                            } ?>                                    
                                            <span role = "presentation" aria-hidden = "true"> · </span>
                                            <div class = "comment-details-menu">
                                                <p><?php echo $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($rowdata['created_date']))); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                } ?>
                        </div>
                    </div>
                </div>
                <div class = "post-design-commnet-box col-md-12">
                    <div class = "post-design-proo-img hidden-mob">
                        <?php
                        $business_userimage = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_user_image;                        
                        if($business_userimage != ''){ ?>
                            <img src = "<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_userimage; ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';" alt = "NOBUSIMAGE"><?php 
                        }
                        else{ ?>
                            <img src = "<?php echo base_url(NOBUSIMAGE); ?>" onerror="this.onerror=null;this.src='<?php echo base_url(NOBUSIMAGE); ?>';" alt = "NOBUSIMAGE"><?php
                        } 
                        ?>
                    </div>
                    <div id = "content" class = "col-md-12  inputtype-comment cmy_2" >
                        <div contenteditable = "true" class = "edt_2 editable_text" name = "<?php echo $post_business_profile_post_id ?>" id = "post_comment<?php echo $post_business_profile_post_id ?>" placeholder = "Add a Comment ..." onClick = "entercomment(<?php echo $post_business_profile_post_id ?>)" onpaste = "OnPaste_StripFormatting(this, event);">
                        </div>
                        <div class="mob-comment">
                            <button id="<?php echo $post_business_profile_post_id ?>" onClick="insert_comment(this.id)">
                                <img src="<?php echo base_url('assets/img/send.png'); ?>" alt="send.png">
                            </button>
                        </div>
                    </div>
                    <div class = "comment-edit-butn hidden-mob">
                        <button id = "<?php echo $post_business_profile_post_id ?>" onClick = "insert_comment(this.id)">Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    /*if($feed_counter % ADS_BREAK == 0)
    {
        echo '<div class="tab-add">'.$infeed_add.'</div>';
    }*/
    $feed_counter ++;
    }
}
else if($page == 1)
{?>
    <div class="user_no_post_avl" ng-if="postData.length == 0">
        <h3>Post</h3>
        <div class="user-img-nn">
            <div class="user_no_post_img">
                <img src="<?php echo base_url('assets/img/no-post.png'); ?>" alt="bui-no.png">
            </div>
            <div class="art_no_post_text">No Post Available.</div>
        </div>
    </div>
    <?php
} 
?>