                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Dashboard</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Ubah Password</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Ubah Password</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-madison">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-key"></i>Form Ubah Password</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 20px;">
                                            <div class="scroller" style="min-height: 20px; overflow: hide; width: auto;" data-initialized="1">
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Password saat ini </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Password Anda saat ini" id="current_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Password baru </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Password baru" id="new_password" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Konfirmasi password baru </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Konfirmasi password baru" id="confirm_password" required>
                                                        </div>
                                                    </div> 
                                                </form>
                                                <div class="col-lg-12">
                                                    <a href="#">
                                                        <button class="btn btn-primary pull-right" id="btn_update">Update Password</button>
                                                    </a> 
                                                    <a href="<?php echo site_url() ?>/keamananrumah/dashboard/">
                                                        <button class="btn btn-warning pull-right" style="margin-right:10px;">Kembali</button>
                                                    </a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div>
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready(function(){
                    function update_password(){
                        var notif = "";
                        var current_password = document.getElementById("current_password").value;
                        var new_password = document.getElementById("new_password").value;
                        var confirm_password = document.getElementById("confirm_password").value;
                        if(current_password == "" || current_password == null  || 
                            new_password == "" || new_password == null  || 
                            confirm_password == "" || confirm_password == null){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Isi field dengan lengkap!'
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        }else
                        if(current_password.length < 6 || new_password.length < 6 || confirm_password.length < 6){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Panjang password harus lebih besar atau sama dengan 6 digit!'
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        }else{
                            var post = {
                                "password" : current_password,
                                "new_password" : new_password
                            }; 
                            $.ajax({
                                url : '<?php echo site_url(); ?>/api/update_password/<?php echo $this->session->userdata("session_appssystem_id"); ?>/' ,
                                type : 'POST',
                                dataType : 'json',
                                data : post,
                                success : function(response){
                                    console.log(response);
                                    if(response.response.status_cek === 'FAILED' || response.response.status_cek === 'NOT MATCH' || response.response.status_cek === 'NO DATA POSTED'){
                                        notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                        notif += response.response.message;
                                        notif += '</div>';
                                        document.getElementById('notif').innerHTML = notif;
                                    }else
                                    if(response.response.status_cek === 'SUCCESS'){
                                        notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                        notif += response.response.message;
                                        notif += '</div>';
                                        document.getElementById('notif').innerHTML = notif;
                                    }
                                },
                                error : function(response){
                                    notif += '<div class="alert alert-danger alert-dismissable">';
                                    notif += 'Terjadi kesalahan pada saat update password. Silahkan coba lagi.';
                                    notif += '</div>';
                                    document.getElementById('notif').innerHTML = notif;
                                },
                            });
                        } 
                        $("#current_password").val('');
                        $("#new_password").val('');
                        $("#confirm_password").val(''); 
                    }
                    $("#btn_update").click(update_password);
                });
                </script>
				
                
            