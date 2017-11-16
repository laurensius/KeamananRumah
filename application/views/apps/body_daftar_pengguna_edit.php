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
                                    <span>Edit Pengguna</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Edit Pengguna</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Edit Pengguna
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
                                                        <label class="col-md-3 control-label">Password </label>
                                                        <div class="col-md-9">
                                                            <input type="password" class="form-control" placeholder="Password" id="password" required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Nama </label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Nama Lengkap Anda" id="nama" required>
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Alamat</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" placeholder="Alamat tempat tinggal" id="alamat" ></textarea required>
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
                                                        <label class="col-md-3 control-label">Status Account</label>
                                                        <div class="col-md-9">
                                                            <!-- <input type="text" class="form-control" placeholder="Status Account" id="status" disabled> -->
                                                            <!-- <span class="help-block"> A block of help text. </span> -->
                                                            <select id="status" class="form-control">
                                                            </select>
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
                                                    <button class="btn btn-primary pull-right" id="btn_update" style="margin-right:10px;">Simpan</button>
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
                var opt_status = "";
                var id = '<?php echo $this->uri->segment(4); ?>';
                $(document).ready(function(){
                    $.ajax({
                        url : '<?php echo site_url(); ?>/api/load_detail_user/'+id+'/' ,
                        type : 'GET',
                        dataType : 'json',
                        success : function(response){
                            console.log(response);
                            if(response.response[0].status == "1"){
                                opt_status += '<option value="1" selected>Active</option>';
                                opt_status += '<option value="2">Blocked</option>';
                            }else
                            if(response.response[0].status == "2"){
                                opt_status += '<option value="1">Active</option>';
                                opt_status += '<option value="2" selected>Blocked</option>';
                            }
                            document.getElementById("username").value = response.response[0].username;
                            document.getElementById("password").value = response.response[0].password;
                            document.getElementById("nama").value = response.response[0].nama;
                            document.getElementById("alamat").value = response.response[0].alamat;
                            document.getElementById("tipe").value = response.response[0].tipe_user;
                            document.getElementById("status").innerHTML = opt_status;
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

                function update_pengguna(){
                    $("#notif").html("");
                    if(username == "" || username == null  || nama == "" || nama == null || alamat == ""  || alamat == null  ){
                        notif += '<div class="alert alert-warning alert-dismissable">';
                        notif += 'Isi semua data dengan lengkap!'
                        notif += '</div>';
                        document.getElementById('notif').innerHTML = notif;
                    }else{
                        var post = {
                            "password" : $("#password").val(),
                            "status" : $("#status").val(),
                            "nama" : $("#nama").val(),
                            "alamat" : $("#alamat").val()
                        }; 
                        $.ajax({
                            url : '<?php echo site_url(); ?>/api/update_pengguna/'+id+'/' ,
                            type : 'POST',
                            dataType : 'json',
                            data : post,
                            success : function(response){
                                console.log(response.affected);
                                if(response.response.status_cek === 'FAILED' || response.response.status_cek === 'FOUND' || response.response.status_cek === 'NO DATA POSTED'){
                                    notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                    notif += response.response.message;
                                    notif += '</div>';
                                    document.getElementById('notif').innerHTML = notif;
                                }else{
                                    window.location = "<?php echo site_url(); ?>/keamananrumah/daftar_pengguna/";
                                }
                            },
                            error : function(response){
                                notif += '<div class="alert alert-danger alert-dismissable">';
                                notif += 'Terjadi kesalahan pada saat update detail pengguna. Silahkan coba lagi.';
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif;
                            },
                        });  
                    }
                }
                $("#btn_update").click(update_pengguna);
                </script>
                
				
                
            