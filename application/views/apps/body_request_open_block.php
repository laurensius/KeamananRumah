                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Kelola Pengguna</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Request Open Blokir</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Request Open Blokir</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Request Open Blokir</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 200px;">
                                            <div class="scroller" style="min-height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                            <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Username</th>
                                                            <th>Tipe</th>
                                                            <th>Status </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="daftar_pengguna">
                                                    </tbody>
                                                </table>  
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
                var daftar_pengguna = ""
                $(document).ready(function(){
                    function load_blocked(){
                        $.ajax({
                            url : '<?php echo site_url(); ?>/api/load_blocked_user_by_api_key/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/' ,
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response.response.length);
                                var no = 1;
                                daftar_pengguna = '';
                                if(response.response.length > 0){ 
                                    for(var x=0;x<response.response.length;x++){
                                        daftar_pengguna += '<tr>';
                                        daftar_pengguna += '<td>'+ no + '</td>';
                                        daftar_pengguna += '<td>'+ response.response[x].username+'</td>';
                                        daftar_pengguna += '<td>'+ response.response[x].tipe+'</td>';
                                        daftar_pengguna += '<td>';
                                        if(response.response[x].status == "1"){
                                            daftar_pengguna += '<span class="label label-primary">Menunggu Approval Root</span>'  
                                        }else{
                                            daftar_pengguna += '<button class="btn btn-primary btn-xs" onClick="request_open('+response.response[x].id+');">';
                                            daftar_pengguna += '<span class="glyphicon glyphicon-edit"></span> Request Open'
                                            daftar_pengguna += '</button>';
                                        }
                                        daftar_pengguna += '</td>';
                                        daftar_pengguna += '</tr>';
                                        no++;    
                                    }
                                }else{
                                    daftar_pengguna += '<tr>';
                                    daftar_pengguna += '<td colspan="4">Tidak ada anggota keluarga terblokir.</td>';
                                    daftar_pengguna += '</tr>';
                                }
                                document.getElementById('daftar_pengguna').innerHTML = daftar_pengguna;
                            },
                            error : function(response){
                                document.getElementById('notif').innerHTML = '';
                                notif += '<div class="alert alert-danger alert-dismissable">';
                                notif += 'Terjadi kesalahan pada saat load detail user. Silahkan coba lagi (refresh browser Anda).';
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif; 
                                notif = "";
                            },
                        });
                    }
                    setInterval(function(){load_blocked();},1000); 
                });

                function request_open(id){
                    $("#notif").html("");
                    notif += '<div class="alert alert-danger">';
                    notif += 'Request open block ?';
                    notif += '<span class="right">';
                    notif += '<button style="margin-left:10px;" class="btn" onClick="clear_notif();">Tidak!</button>';
                    notif += '<button style="margin-left:10px;" class="btn btn-danger" onclick="do_request('+id+');">Ya!</button>';
                    notif += '</span>';
                    notif += '</div>';
                    $("#notif").html(notif);
                    notif = "";
                }

                function clear_notif(){
                    document.getElementById('notif').innerHTML = '';
                }

                function do_request(id){
                    var post = {
                        "user_blocked" : id,
                        "user_request" : "<?php echo $this->session->userdata("session_appssystem_id"); ?>",
                        "status" : "1"
                    };
                    $.ajax({
                        url : "<?php echo site_url(); ?>/api/request_open_block/",
                        type : "POST",
                        dataType : "json",
                        data: post,
                        success : function(response){
                            if(response.response.status_cek === 'FAILED' || response.response.status_cek === 'NO DATA POSTED'){
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
                            notif += '<div class="alert alert-danger alert-dismissable">';
                            notif += 'Terjadi kesalahan pada saat proses request. Silahkan coba lagi.';
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                            notif = "";
                        },
                    });
                }
                </script>


