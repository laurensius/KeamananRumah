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
                                    <span>Delete Pengguna</span>
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Delete Pengguna</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif">
                                    <div class="alert alert-danger">
                                        Apakah Anda yakin akan menghapus pengguna ini?
                                        <span class="right">
                                            <a href="<?php echo site_url(); ?>/keamananrumah/daftar_pengguna/"><button class="btn">Tidak!</button></a>
                                            <button class="btn btn-danger" onclick="ya(<?php echo $this->uri->segment(4); ?>);">Ya!</button>
                                        </span>
                                    </div>
                                </span>
                            </div>
                            <!-- <div class="col-lg-12">
                                <div class="portlet box green-meadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Delete Pengguna
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 2  0px;">
                                            <div class="scroller" style="min-height: 20px; overflow: hide; width: auto;" data-initialized="1">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        <div>
                    </div>
                </div>
                <script>
                    function ya(id){
                        alert(id);
                    }
                </script>
                
				
                
            