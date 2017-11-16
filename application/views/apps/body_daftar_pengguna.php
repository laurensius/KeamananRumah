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
                                </li>
                            </ul>
                        </div>
                        <h1 class="page-title"> Daftar Pengguna</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <span id="notif"></span>
                            </div>
                            <div class="col-lg-12">
                                <div class="portlet box blue-chambray">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-users"></i>Daftar Pengguna
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            <a href="" class="fullscreen" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; min-height: 2  0px;">
                                            <div class="scroller" style="min-height: 20px; overflow: hide; width: auto;" data-initialized="1">
                                                <!-- <div class="row">
                                                    <div class="col-lg-12">
                                                        <form class="form-horizontal">
                                                            <div class="form-group">
                                                                <div class="col-lg-3">
                                                                    <select class="form-control" id="kategori">
                                                                        <option value="null">Pilih Kategori Pencarian</option>
                                                                        <option value="username">Username</option>
                                                                        <option value="nama">Nama Pengguna</option>
                                                                        <option value="alamat">Alamat</option>
                                                                        <option value="status">Status</option>
                                                                        <option value="tipe_user">Tipe User</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <input type="text" class="form-control" placeholder="Kata kunci pencarian" id="berdasar" required> 
                                                                </div>
                                                                
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> -->
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Username</th>
                                                            <th>Tipe</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="daftar_pengguna">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5">
                                                                <div class="row">
                                                                    <div class="col-lg-12">Halaman : <select id="select_page"></select></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div>
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    var daftar_pengguna = '';
                    var panjang_data = 0;
                    var response_data;

                    $.ajax({
                        <?php 
                        if($this->session->userdata("session_appssystem_tipe_user") == "1"){
                        ?>
                        url : '<?php echo site_url(); ?>/api/load_all_user/' ,
                        <?php }else
                        if($this->session->userdata("session_appssystem_tipe_user") == "2" || $this->session->userdata("session_appssystem_tipe_user") == "3"){ ?>
                            url : '<?php echo site_url(); ?>/api/load_all_family/<?php echo $this->session->userdata("session_appssystem_api_key"); ?>/' ,
                        <?php } ?>
                        type : 'GET',
                        dataType : 'json',
                        success : function(response){
                            var data_length = response.response.length;
                            panjang_data  = data_length;
                            if(data_length > 0){
                                response_data = response;
                                paginasi(data_length, response, 1);
                                var jumlah_baris_data = data_length;
                                var jumlah_baris_perhalaman = 5;
                                var jumlah_halaman = Math.ceil(jumlah_baris_data / jumlah_baris_perhalaman);
                                if(jumlah_halaman > 1){
                                    var panel_box ='';
                                    var ctr = 1;
                                    for(var x=0;x<jumlah_halaman;x++){
                                        panel_box += '<option value="'+ ctr +'">'+ ctr +'</option>';    
                                        ctr++;
                                    }
                                    $("#select_page").html(panel_box);
                                }
                            }else{
                                daftar_pengguna += '<tr><td colspan="5">Tidak ada data user tersimpan</td></tr>';
                            }
                        },
                        error : function(response){
                            notif += '<div class="alert alert-warning alert-dismissable">';
                            notif += 'Terjadi kesalahan pada saat load data pengguna..';
                            notif += '</div>';
                            document.getElementById('notif').innerHTML = notif;
                        },
                    });

                    function paginasi(data_length, datas, halaman){
                        var jumlah_baris_data = data_length;
                        var jumlah_baris_perhalaman = 5;
                        var jumlah_halaman = Math.ceil(jumlah_baris_data / jumlah_baris_perhalaman);
                        var batas_bawah = (halaman * jumlah_baris_perhalaman) - jumlah_baris_perhalaman;
                        var ctr = 0;
                        if(halaman == jumlah_halaman){
                            var batas_atas = jumlah_baris_data;
                        }else{
                            var batas_atas = (halaman * jumlah_baris_perhalaman);
                        }
                        if(halaman == 1){
                            ctr += 1;
                        }else{
                            ctr = batas_bawah + 1;
                        }
                        console.log("Jumlah baris data : " + jumlah_baris_data);
                        console.log("Jumlah baris perhalamana : " + jumlah_baris_perhalaman);
                        console.log("Jumlah halaman : " + jumlah_halaman);
                        console.log("Halaman terpilih : " + halaman);
                        console.log("Index loop bawah : " + batas_bawah);
                        console.log("Index loop atas  : " + batas_atas);
                        daftar_pengguna = '';
                        for(var x=batas_bawah;x<batas_atas;x++){
                            daftar_pengguna += '<tr>';
                            daftar_pengguna += '<td>'+ctr+'</td>';
                            daftar_pengguna += '<td>'+datas.response[x].username+'</td>';
                            daftar_pengguna += '<td>'+datas.response[x].tipe_user+'</td>';
                            if(datas.response[x].status_user === "Active"){
                                var severity = "success";
                            }else{
                                var severity = "danger";
                            }
                            daftar_pengguna += '<td><span class="badge badge-large badge-'+severity+'">'+datas.response[x].status_user+'</span></td>';
                            daftar_pengguna += '<td>';
                            daftar_pengguna += '<?php if($this->session->userdata("session_appssystem_tipe_user") == "1" || $this->session->userdata("session_appssystem_tipe_user") == "2"){ ?><a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/edit/'+datas.response[x].id+'"><button class="btn btn-xs" type="button" id="btn_edit"><span class="glyphicon glyphicon-pencil"></span></button></a><?php } ?>';
                            daftar_pengguna += '<a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/view/'+datas.response[x].id+'"><button class="btn btn-xs btn-primary" type="button" id="btn_view"><span class="glyphicon glyphicon-eye-open"></span></button></a>';
                            daftar_pengguna += '<?php if($this->session->userdata("session_appssystem_tipe_user") == "1" || $this->session->userdata("session_appssystem_tipe_user") == "2"){ ?><a href="<?php echo site_url() ?>/keamananrumah/daftar_pengguna/delete/'+datas.response[x].id+'"><button class="btn btn-xs btn-danger" type="button" ><span class="glyphicon glyphicon-trash"></span></button></a><?php } ?>';
                            daftar_pengguna += '</td>';
                            daftar_pengguna += '</tr>';
                            ctr++;
                        }
                        $("#daftar_pengguna").html(daftar_pengguna);
                    }

                    $("#select_page").on('change',function(){
                        var hal = $("#select_page").val();
                        paginasi(panjang_data,response_data,hal);
                    });

                    
                });
                </script>
				
                
            