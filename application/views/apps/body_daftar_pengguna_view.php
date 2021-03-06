                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Kelola Pengguna</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Daftar Pengguna</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>View Pengguna</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> View Pengguna</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>View Pengguna
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 2  0px;">
                                            <div class="scroller" style="min-height: 20px; overflow: hide; width: auto;" data-initialized="1">
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
                                                            <input type="text" class="form-control" placeholder="Nama Lengkap Anda" id="nama" disabled required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Alamat</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" placeholder="Alamat tempat tinggal" id="alamat" disabled></textarea required>
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
                                                    <?php if(($this->session->userdata("session_appssystem_tipe_user") == "1" || $this->session->userdata("session_appssystem_tipe_user") == "2") && $this->uri->segment(4) != $this->session->userdata("session_appssystem_id")){ ?>
                                                    <a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/delete/<?php echo $this->uri->segment(4); ?>/">
                                                        <button class="btn btn-danger pull-right" style="margin-right:10px;">Hapus</button>
                                                    </a>
                                                    <a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/edit/<?php echo $this->uri->segment(4); ?>/">
                                                        <button class="btn btn-primary pull-right" id="btn_edit" style="margin-right:10px;">Edit</button>
                                                    </a>
                                                    <?php } ?>
                                                    <a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/">
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
                var notif = "";
                $(document).ready(function(){
                    $.ajax({
                        url : '<?php echo site_url(); ?>/api/load_detail_user/<?php echo $this->uri->segment(4); ?>/' ,
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
                });
                </script>
                
                
                
                
				
                
            