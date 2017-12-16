                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Monitoring</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Laporan</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Laporan</h1>
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
                                            <i class="fa fa-gift"></i>Download Periode Laporan</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 200px;">
                                            <div class="scroller" style="min-height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                                <div class="form-group">
                                                <label>Tanggal Awal Periode Laporan</label>  
                                                <input class="form-control" type="date" name="tanggal_awal" id="tanggal_awal">
                                                </div>
                                                <div class="form-group">
                                                <label>Tanggal Akhir Periode Laporan</label>  
                                                <input class="form-control" type="date" name="tanggal_akhir" id="tanggal_akhir">
                                                </div>
                                                <div class="col-lg-12">
                                                <input class="btn btn-primary pull-right" type="button" name="cek" id="cek_download" value="Cek Laporan">
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
                function cek_download(){
                    if (confirm('Cek Laporan ?')) {
                        $("#notif").html("");
                        if( $("#tanggal_awal").val() == null || $("#tanggal_awal").val() == "" ||
                        $("#tanggal_akhir").val() == null || $("#tanggal_akhir").val() == "" ){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Isi semua data dengan lengkap!'
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                            notif = ''
                        }else{
                            $.ajax({
                                url : '<?php echo site_url(); ?>/api/cek_download/' + $("#tanggal_awal").val() + '/' + $("#tanggal_akhir").val() + '/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/'  ,
                                type : 'GET',
                                dataType : 'json',
                                success : function(response){
                                   console.log(response);
                                   if(response.response[0].jumlah_record != "0"){
                                    notif += '<div class="alert alert-success alert-dismissable">';
                                    notif += 'Data tersedia klik <a href="<?php echo site_url(); ?>/api/download_report/' + $("#tanggal_awal").val() + '/' + $("#tanggal_akhir").val() + '/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/" target="_blank">di sini</a> untuk download laporan!';
                                    notif += '</div>';
                                    document.getElementById('notif').innerHTML = notif;
                                    notif = ''
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
                }
                $("#cek_download").click(cek_download);
                </script>


