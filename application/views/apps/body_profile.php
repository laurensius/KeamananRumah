                <div class="page-content-wrapper red">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Dashboard</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Profile</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Profile</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Profile</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <!-- <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a> -->
                                            <!-- <a href="javascript:;" class="reload" data-original-title="" title=""> </a> -->
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                            <!-- <a href="javascript:;" class="remove" data-original-title="" title=""> </a> -->
                                        </div>
                                    </div>
                                    <div class="portlet-body" id="detail_user">
                                        <div class="slimScrollDiv">
                                            <div class="scroller">
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Username </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Username" id="username" disabled required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Nama </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Nama Lengkap Anda" id="nama" <?php echo $disabled; ?> required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Alamat</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" placeholder="Alamat tempat tinggal" id="alamat" <?php echo $disabled; ?>></textarea required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Tipe Account</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Tipe Account" id="tipe" disabled>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Tanggal Registrasi</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Tanggal Registrasi" id="register_date" disabled>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">API Key</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="API Key" id="API_KEY" disabled>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Secure Key</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Secure Key" id="secure_key" disabled>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-lg-12">
                                                    <?php
                                                    if($this->uri->segment(3)=="update"){
                                                    ?>
                                                    <a href="#">
                                                        <button class="btn btn-primary pull-right" id="btn_update">Update</button>
                                                    </a> 
                                                    <a href="<?php echo site_url() ?>/keamananrumah/profile/">
                                                        <button class="btn btn-warning pull-right" style="margin-right:10px;">Kembali</button>
                                                    </a> 
                                                    <?php 
                                                    }else{ ?>
                                                    <a href="<?php echo site_url() ?>/keamananrumah/profile/update/">
                                                        <button
                                                         class="btn btn-primary pull-right">Edit Data</button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 49.9376px;"></div>
                                        <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                                    </div>
                                </div>
                            </div>
                        <div>
                    </div>
                </div>
                <script type="text/javascript">
                var notif = "";
                $(document).ready(function(){
                    $.ajax({
                        url : '<?php echo site_url(); ?>/api/load_detail_user/<?php echo $this->session->userdata("session_appssystem_id"); ?>/' ,
                        type : 'GET',
                        dataType : 'json',
                        success : function(response){
                            console.log(response);
                            document.getElementById("username").value = response.response[0].username;
                            document.getElementById("nama").value = response.response[0].nama;
                            document.getElementById("alamat").value = response.response[0].alamat;
                            document.getElementById("tipe").value = response.response[0].tipe_user;
                            document.getElementById("register_date").value = response.response[0].register_datetime;
                            document.getElementById("API_KEY").value = response.response[0].API_KEY;
                            document.getElementById("secure_key").value = response.response[0].secure_key;
                        },
                        error : function(response){
                            notif += '<div class="alert alert-danger alert-dismissable">';
                            notif += 'Terjadi kesalahan pada saat load detail user. Silahkan coba lagi (refresh browser Anda).';
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        },
                    });

                    function update_profile(){
                        var username = document.getElementById("username").value;
                        var nama = document.getElementById("nama").value;
                        var alamat = document.getElementById("alamat").value;
                        if(username == "" || username == null  || nama == "" || nama == null || alamat == ""  || alamat == null  ){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Isi semua data dengan lengkap!'
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        }else{
                            var post = {
                                "username" : username,
                                "nama" : nama,
                                "alamat" : alamat
                            }; 
                            console.log(post);
                            $.ajax({
                                url : '<?php echo site_url(); ?>/api/update_detail_user/<?php echo $this->session->userdata("session_appssystem_id"); ?>/' ,
                                type : 'POST',
                                dataType : 'json',
                                data : post,
                                success : function(response){
                                    console.log(response);
                                    if(response.response.status_cek === 'FAILED' || response.response.status_cek === 'FOUND' || response.response.status_cek === 'NO DATA POSTED'){
                                        notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                        notif += response.response.message;
                                        notif += '</div>';
                                        document.getElementById('notif').innerHTML = notif;
                                    }else{
                                        window.location = "<?php echo site_url(); ?>/keamananrumah/profile/";
                                    }
                                },
                                error : function(response){
                                    notif += '<div class="alert alert-danger alert-dismissable">';
                                    notif += 'Terjadi kesalahan pada saat update detail profile. Silahkan coba lagi.';
                                    notif += '</div>';
                                    document.getElementById('notif').innerHTML = notif;
                                },
                            });
                        }  
                    }
                    $("#btn_update").click(update_profile);
                });
                </script>
				
                
            