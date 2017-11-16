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
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 yellow-crusta" href="#">
                                    <div class="visual">
                                        <i class="fa fa-database"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup"><span id="total_record">0</span></span>
                                        </div>
                                        <div class="desc"> Record Total </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Pengguna Aktif</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <!-- <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a> -->
                                            <!-- <a href="javascript:;" class="reload" data-original-title="" title=""> </a> -->
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                            <!-- <a href="javascript:;" class="remove" data-original-title="" title=""> </a> -->
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                            <div class="scroller" style="height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                                <p></p>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"></div>
                        <div>
                    </div>
                </div>
                <script type="text/javascript">
                var notif = "";
                $(document).ready(function(){
                    function load_data(){
                        $.ajax({
                            url : '<?php echo site_url(); ?>/api/dashboard/' ,
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response);
                                $("#total_pengguna").html(response.response.user[0].jumlah_user_total);
                                $("#pengguna_diblock").html(response.response.user[0].jumlah_user_blocked);
                                $("#record_hari_ini").html(response.response.database[0].jumlah_record_today);
                                $("#total_record").html(response.response.database[0].jumlah_record_total);
                            },
                            error : function(response){
                                
                            },
                        });
                    }
                    setInterval(function(){load_data();},1000);
                });
                </script>
				
                
            