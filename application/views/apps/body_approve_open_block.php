                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Kelola Pengguna</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Approve Open Block</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Approve Open Block</h1>
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
                                            <i class="fa fa-gift"></i>Approve Open Block</div>
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
                            url : '<?php echo site_url(); ?>/api/load_request_block/',
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
                                        daftar_pengguna += '<button class="btn btn-primary btn-xs" onClick="approve_open('+response.response[x].id+','+response.response[x].user_blocked+');">';
                                        daftar_pengguna += '<span class="glyphicon glyphicon-check"></span> Approve'
                                        daftar_pengguna += '</button>';
                                        daftar_pengguna += '</td>';
                                        daftar_pengguna += '</tr>';
                                        no++;    
                                    }
                                }else{
                                    daftar_pengguna += '<tr>';
                                    daftar_pengguna += '<td colspan="4">Tidak ada request open block.</td>';
                                    daftar_pengguna += '</tr>';
                                }
                                document.getElementById('daftar_pengguna').innerHTML = daftar_pengguna;
                            },
                            error : function(response){
                                document.getElementById('notif').innerHTML = '';
                                notif += '<div class="alert alert-danger alert-dismissable">';
                                notif += 'Terjadi kesalahan pada saat load request open block. Silahkan coba lagi (refresh browser Anda).';
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif; 
                                notif = "";
                            },
                        });
                    }
                    setInterval(function(){load_blocked();},1000); 
                });

                function approve_open(id_request,id_user){
                    $("#notif").html("");
                    notif += '<div class="alert alert-danger">';
                    notif += 'Approve open block ?';
                    notif += '<span class="right">';
                    notif += '<button style="margin-left:10px;" class="btn" onClick="clear_notif();">Tidak!</button>';
                    notif += '<button style="margin-left:10px;" class="btn btn-danger" onclick="do_approve('+id_request+','+id_user+');">Ya!</button>';
                    notif += '</span>';
                    notif += '</div>';
                    $("#notif").html(notif);
                    notif = "";
                }

                function clear_notif(){
                    document.getElementById('notif').innerHTML = '';
                }

                function do_approve(id_request,id_user){
                    var post = {
                        "id_request" : id_request,
                        "id_user" : id_user,
                        "status" : "2"
                    };
                    $.ajax({
                        url : "<?php echo site_url(); ?>/api/do_approve/",
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
                            notif += 'Terjadi kesalahan pada saat proses approve. Silahkan coba lagi.';
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                            notif = "";
                        },
                    });
                }
                </script>


