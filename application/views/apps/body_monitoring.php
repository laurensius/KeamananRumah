                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span>Monitoring</span>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Monitoring</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Monitoring Sensor</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="portlet box green-meadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Human Detector Outdoor</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                            <div class="scroller" style="height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                                <center>
                                                    <h1 id="outdoor_status"></h1>
                                                </center>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="portlet box green-meadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Human Detector Indoor</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                            <div class="scroller" style="height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                            <center>
                                                    <h1 id="indoor_status"></h1>
                                                </center>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="portlet box green-meadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Door / Lock Sensor</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                            <div class="scroller" style="height: 200px; overflow: hide; width: auto;" data-initialized="1">
                                                <center>
                                                    <h1 id="door_lock_status"></h1>
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
                $(document).ready(function(){
                    function load_recent(){
                        $.ajax({
                            url : '<?php echo site_url(); ?>/api/recent/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/' ,
                            type : 'GET',
                            dataType : 'json',
                            success : function(response){
                                console.log(response);
                                $("#outdoor_status").html(response.response[0].outdoor);
                                $("#indoor_status").html(response.response[0].indoor);
                            },
                            error : function(response){
                                notif += '<div class="alert alert-danger alert-dismissable">';
                                notif += 'Terjadi kesalahan pada saat load detail user. Silahkan coba lagi (refresh browser Anda).';
                                notif += '</div>';
                                document.getElementById('notif').innerHTML = notif;
                            },
                        });
                    }
                    setInterval(function(){load_recent();},1000);
                    
                });
                </script>


