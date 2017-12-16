                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Dashboard</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>System dashboard</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Dashboard</h1>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_total_pengguna">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="total_pengguna">0</span></span>
                                        </div>
                                        <div class="desc"> Total Pengguna </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_pengguna_diblock">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="pengguna_diblock">0</span></span>
                                        </div>
                                        <div class="desc"> Pengguna Diblock </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_total_koordinator">
                                <a class="dashboard-stat dashboard-stat-v2 green-turquoise" href="#">
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="total_coordinator">0</span></span>
                                        </div>
                                        <div class="desc"> Total Coordinator </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_total_sibling">
                                <a class="dashboard-stat dashboard-stat-v2 yellow-saffron" href="#">
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="total_sibling">0</span></span>
                                        </div>
                                        <div class="desc"> Total Sibling </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_record_har_ini">
                                <a class="dashboard-stat dashboard-stat-v2 green-turquoise" href="#">
                                    <div class="visual">
                                        <i class="fa fa-server"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="record_hari_ini">0</span></span>
                                        </div>
                                        <div class="desc"> Record Hari Ini </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_record_total">
                                <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="#">
                                    <div class="visual">
                                        <i class="fa fa-database"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="box_total_record">0</span></span>
                                        </div>
                                        <div class="desc"> Record Total </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_request_buka_block">
                                <a class="dashboard-stat dashboard-stat-v2 green-turquoise" href="#">
                                    <div class="visual">
                                        <i class="fa fa-server"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="request_buka_block">0</span></span>
                                        </div>
                                        <div class="desc"> Request Buka Block</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="box_total_perangkat_aktif">
                                <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="#">
                                    <div class="visual">
                                        <i class="fa fa-database"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="total_perangkat_aktif">0</span></span>
                                        </div>
                                        <div class="desc"> Total Perangkat Aktif </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                var notif = "";
                $(document).ready(function(){
                    function load_data(){
                        var tipe_user = '<?php echo $this->session->userdata("session_appssystem_tipe_user"); ?>'; 
                        $.ajax({
                            <?php 
                            if($this->session->userdata("session_appssystem_tipe_user") == "1"){
                            ?>
                            url : '<?php echo site_url(); ?>/api/dashboard/' ,
                            <?php }else
                            if($this->session->userdata("session_appssystem_tipe_user") == "2" || $this->session->userdata("session_appssystem_tipe_user") == "3"){ ?>    
                            url : '<?php echo site_url(); ?>/api/dashboard/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/',
                            <?php } ?>
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response);
                                $("#total_pengguna").html(response.response.user[0].jumlah_user_total);
                                $("#pengguna_diblock").html(response.response.user[0].jumlah_user_blocked);
                                $("#record_hari_ini").html(response.response.database[0].jumlah_record_today);
                                $("#total_record").html(response.response.database[0].jumlah_record_total);
                                if(tipe_user == "1"){
                                    $("#request_buka_block").html(response.response.request_buka_block[0].request_buka_block);
                                    $("#total_coordinator").html(response.response.jumlah_koordinator[0].jumlah_koordinator);
                                    $("#total_sibling").html(response.response.jumlah_sibling[0].jumlah_sibling);
                                    $("#total_perangkat_aktif").html(response.response.total_perangkat_aktif[0].jumlah_perangkat_aktif);    
                                }else{
                                    $("#box_request_buka_block").remove();
                                    $("#box_total_koordinator").remove();
                                    $("#box_total_sibling").remove();
                                    $("#box_total_perangkat_aktif").remove();  
                                }
                                
                            },
                            error : function(response){
                                
                            },
                        });
                    }
                    setInterval(function(){load_data();},1000);
                });
                </script>
				
                
            