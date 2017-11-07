                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Kelola Pengguna</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Tambah Pengguna</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Tambah Pengguna</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-madison">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Form Tambah Pengguna</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 20px;">
                                            <div class="scroller" style="min-height: 20px; overflow: hide; width: auto;" data-initialized="1">
                                                <form action="javascript:;" class="login-form" method="post" id="form_daftar">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="username" id="username" required/> 
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" id="password" required/>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Nama Lengkap" name="nama" id="nama" required/> 
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <select class="form-control form-control-solid placeholder-no-fix form-group" name="parent" id="parent"/>
                                                            </select> 
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Alamat tempat tinggal" name="alamat" id="alamat" required/> 
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12 text-right">
                                                            <button class="btn green" id="daftar" type="submit">Daftar</button>
                                                        </div>
                                                    </div>
                                                </form>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div>
                    </div>
                </div>
                <script>
                    $.ajax({
                        url : '<?php echo site_url(); ?>/api/load_all_parent/' ,
                        type : 'GET',
                        dataType : 'json',
                        success : function(response){
                            var options = '<option value="0">Jadikan sebagai user baru tipe coordinator </option>';
                            for(var x=0;x<response.response.length;x++){
                                options += '<option value="'+response.response[x].id+'">User sibling dari '+response.response[x].username+ ' - '+response.response[x].nama+ ' </option>';
                            }
                            $("#parent").html(options);
                        },
                        error : function(response){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Terjadi kesalahan pada saat load koordinator. Silahkan coba lagi.';
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        },
                    });
                    
                    
                    $(document).ready(function(){
                        function cek_daftar(){
                            var username = document.getElementById("username").value;
                            var password = document.getElementById("password").value;
                            var nama = document.getElementById("nama").value;
                            var alamat = document.getElementById("alamat").value;
                            var parent = document.getElementById("parent").value;
                            var tipe_user = ""; 
                            if(parent==="0"){
                                tipe_user = "2";
                            }else{
                                tipe_user = "3";
                            }
                            var notif = '';
                            if(username == "" || username == null || password == "" || password == null || 
                            nama == "" || nama == null || alamat == ""  || alamat == null  ){
                                notif += '<div class="alert alert-warning alert-dismissable">';
                                notif += 'Isi semua data dengan lengkap!'
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif;
                            }else{
                                var post = {
                                    "username" : username,
                                    "password" : password,
                                    "nama" : nama,
                                    "alamat" : alamat,
                                    "parent" : parent,
                                    "tipe_user" : tipe_user
                                };  
                                $.ajax({
                                    url : "<?php echo site_url(); ?>/api/verifikasi_daftar/",
                                    type : "POST",
                                    dataType : "json",
                                    data: post,
                                    success : function(response){
                                        if(response.response.status_cek === 'FAILED' || response.response.status_cek === 'FOUND' || response.response.status_cek === 'NO DATA POSTED'){
                                            notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                            notif += response.response.message;
                                            notif += '</div>';
                                            document.getElementById('notif').innerHTML = notif;
                                        }else{
                                            notif += '<div class="alert alert-' + response.response.message_severity + ' alert-dismissable">';
                                            notif += response.response.message;
                                            notif += '</div>';
                                            document.getElementById('notif').innerHTML = notif;
                                        }
                                    },
                                    error : function(response){
                                        alert("Terjadi kesalahan pada saat proses pendaftaran. Silahkan coba lagi.");
                                    },
                                });
                            }
                        }
                        $("#daftar").click(cek_daftar);
                    });
                </script>

				
                
            