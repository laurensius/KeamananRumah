                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Monitoring</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Kelola Perangkat</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Kelola Perangkat</h1>
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
                                            <i class="fa fa-gift"></i>Kelola perangkat</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 200px;">
                                            <div class="scroller" style="min-height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                                <center>
                                                    <span id="btn_toggle"></span><br>
                                                    <h3><span id="msg"></span></h3>
                                                </center>    
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
                // var btn_on = '<a onClick="changeState(2);"><img src="<?php echo base_url(); ?>assets/img/png_on.png"></a>';
                // var btn_off = '<a onClick="changeState(1);"><img src="<?php echo base_url(); ?>assets/img/png_off.png"></a>';
                var btn_on = '<button class="btn btn-primary" onClick="changeState(2);">LAMPU ON KLIK UNTUK MEMATIKAN</button>';
                var btn_off = '<button class="btn btn-danger" onClick="changeState(1);">LAMPU OFF KLIK UNTUK MENYALAKAN</button>';
                $(document).ready(function(){
                    function load_recent(){
                        $.ajax({
                            url : '<?php echo site_url(); ?>/api/status_perangkat_by_api/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/' ,
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response);
                                if(response.response[0].status == "1"){
                                    $("#btn_toggle").html(btn_on);
                                    $("#msg").html("Kondisi perangkat : ON");
                                }else
                                if(response.response[0].status == "2"){
                                    $("#btn_toggle").html(btn_off);
                                    $("#msg").html("Kondisi perangkat : OFF");
                                }
                            },
                            error : function(response){
                                notif += '<div class="alert alert-danger alert-dismissable">';
                                notif += 'Terjadi kesalahan pada saat load status prangkat. Silahkan coba lagi (refresh browser Anda).';
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif;
                                // $("#notif").html(notif);
                            },
                        });
                    }
                    setInterval(function(){load_recent();},1000);
                });

                function changeState(state){
                    $.ajax({
                            url : '<?php echo site_url(); ?>/api/change_device_status/' + state + '/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/<?php echo $this->session->userdata("session_appssystem_id"); ?>/' ,
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response);
                            },
                            error : function(response){
                            },
                        });
                }
                </script>


