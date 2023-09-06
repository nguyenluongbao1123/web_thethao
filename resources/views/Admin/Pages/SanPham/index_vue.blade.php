@extends('Admin.share.master')
@section('title')
    <h1 class="text-center mb-4" style="padding-top: 30px"> Quản Lý Sản Phẩm</h1>
@endsection
@section('content')
    <div class="row" id="app">
        <div class="card">
            <div class="modal fade" id="modalSanPham" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <form id="createSanPham" v-on:submit.prevent="addSP()">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thêm mới sản phẩm</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Mã sản phẩm</label>
                                            <input tabindex="1" v-model="ma_san_pham"  v-on:blur="checkTenSanPham() , checkSlugSanPham() ,checkMaSanPham()" class="form-control" name="ma_san_pham" id="ma_san_pham"
                                                type="text" placeholder="Nhập vào mã sản phẩm">
                                            <small id="message_ma_san_pham" ><i>@{{message_ma_san_pham}}</i></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tên sản phẩm</label>
                                            <input tabindex="1" class="form-control" v-on:keyup="chuyenDoiSlug()"
                                                v-model="ten_san_pham" v-on:blur="checkTenSanPham() , checkSlugSanPham() , checkMaSanPham()" name="ten_san_pham" id="ten_san_pham" type="text"
                                                placeholder="Nhập vào tên sản phẩm">
                                            <small id="message_ten_san_pham"><i>@{{message_ten_san_pham}}</i></small>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Slug sản phẩm</label>
                                            <input tabindex="1" class="form-control" name="slug_san_pham" v-model="slug" v-on:blur="checkTenSanPham() , checkSlugSanPham() ,checkMaSanPham()"
                                                id="slug_san_pham" type="text" placeholder="Nhập vào slug sản phẩm">
                                            <small id="message_slug_san_pham"><i>@{{message_slug_san_pham}}</i></small>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Giá</label>
                                            <input tabindex="1" class="form-control" name="gia" id="gia" type="text"
                                                placeholder="Nhập giá">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Giá khuyến mãi</label>
                                            <input tabindex="1" class="form-control" name="gia_khuyen_mai" id="gia_khuyen_mai"
                                                type="text" placeholder="Nhập giá khuyến mãi">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng</label>
                                            <input tabindex="3" class="form-control" name="so_luong" type="number" id="so_luong"
                                                placeholder="Nhập số lượng" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Chi tiết</label>
                                            <textarea name="chi_tiet" id="chi_tiet" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Hình Ảnh</label>
                                            <div class="input-group">
                                                <input name="hinh_anh" id="hinh_anh" class="form-control" type="text"
                                                    name="filepath">
                                                <span class="input-group-prepend">
                                                    <a id="lfm" data-input="hinh_anh" data-preview="holder"
                                                        class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                            </div>
                                            <div id="holder" style="margin-top:15px;max-height:100px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Danh mục</label>
                                            <select name="ma_danh_muc_id" id="ma_danh_muc_id" class="form-control">
                                                @foreach ($danhMuc as $value)
                                                    <option value={{ $value->id }}> {{ $value->ten_danh_muc }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Trạng Thái</label>
                                            <select tabindex="8" name="is_open" id="is_open" class="form-control">
                                                <option value=0>Tạm tắt</option>
                                                <option value=1>Hiển thị</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary " type="button" data-bs-dismiss="modal">Đóng</button>
                                <button class="btn btn-secondary" type="submit">Thêm
                                    mới</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">

                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search"
                                aria-label="Search" id="searchSanPham" v-model="key_search" v-on:keyup.enter="search()">
                            <div class="input-group-append">
                                <button class="input-group-text red lighten-3" id="basic-text1" v-on:click="search()"><i
                                        class="fas fa-search text-grey" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test"
                            data-bs-target="#modalSanPham"><i class="fa fa-plus-square" aria-hidden="true"></i></button>
                    </div>
                </div>



                <div class="mt-4 table-responsive">
                    <table class="table table-bordered table-responsive " id="listSanPham">
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-center text-nowrap"><b>#</b></th>
                                <th class="text-center text-nowrap"><b>Mã sản phẩm</b></th>
                                <th class="text-center text-nowrap"><b>Tên sản phẩm</b></th>
                                <th class="text-center text-nowrap" style="min-width: 150px;"><b>Hình ảnh</b></th>
                                <th class="text-center text-nowrap"><b>Số lượng</b></th>
                                <th class="text-center text-nowrap"><b>Danh mục</b></th>
                                <th class="text-center text-nowrap"><b>Giá</b></th>
                                <th class="text-center text-nowrap"><b>Giá khuyến mãi</b></th>
                                <th class="text-center text-nowrap"><b>Chi tiết</b></th>
                                <th class="text-center text-nowrap"><b>Trạng thái</b></th>
                                <th class="text-center text-nowrap"><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(v, k) in list_sp">
                                <tr class="bg-light">
                                    <th class="text-center align-middle">@{{ k + 1 }}</th>
                                    <td class="align-middle">@{{ v.ma_san_pham }}</td>
                                    <td class="align-middle">@{{ v.ten_san_pham }}</td>
                                    <td class="align-middle">
                                        <div v-bind:id="'carouselExampleControls' + v.id" class="carousel slide"
                                            data-bs-ride="carousel" data-bs-interval="1000">
                                            <div class="carousel-inner">
                                                <template v-for="(v1, k1) in stringToArray(v.hinh_anh)">
                                                    <template v-if="k1 == 0">
                                                        <div class="carousel-item active">
                                                            <img style="height: 100px" v-bind:src="v1"
                                                                class="d-block w-100" alt="...">
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <div class="carousel-item">
                                                            <img style="height: 100px" v-bind:src="v1"
                                                                class="d-block w-100" alt="...">
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>
                                            <a class="carousel-control-prev" type="button"
                                                v-bind:data-bs-target="'#carouselExampleControls' + v.id"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" type="button"
                                                v-bind:data-bs-target="'#carouselExampleControls' + v.id"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        </div>

                                    </td>
                                    <td class="align-middle text-center">@{{ v.so_luong }}</td>
                                    <td class="align-middle text-nowrap">@{{ v.ten_danh_muc }}</td>
                                    <td class="align-middle text-center">@{{ formatPrice(v.gia) }}đ</td>
                                    <td class="align-middle text-center">@{{ formatPrice(v.gia_khuyen_mai) }}đ</td>
                                    <td class="align-middle"><button v-on:click="modal = v, hienChiTiet()"
                                            data-bs-toggle="modal" data-bs-target="#moTaChiTiet"
                                            class="btn btn-primary"><i class="fa-solid fa-info"></i></button></td>

                                    <td class="align-middle text-nowrap">

                                        <button v-if="v.is_open == 1" v-on:click="changeIsOpen(v.id)"
                                            class="btn btn-success">Hiển Thị</button>

                                        <button v-else v-on:click="changeIsOpen(v.id)" class="btn btn-danger">Tạm
                                            Tắt</button>

                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button v-on:click="showUpdate(v)" style="width: 0px" data-bs-toggle="modal"
                                            data-bs-target="#editModal" class="btn"><i
                                                class="fa fa-pencil-square text-primary"style="font-size: 20px"></i></i><span
                                                class="ps-3 text-success"></button>
                                        <button v-on:click="delete_sp = v" style="width: 0px" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" class="btn" style="margin-left: 10px"><i
                                                class="fa fa-trash text-danger"style="font-size: 20px"></i></i><span
                                                class="ps-3 text-success"></button>
                                    </td>
                                </tr>
                            </template>
                            {{-- Chi Tiết --}}
                            <div class="modal fade" id="moTaChiTiet" tabindex="-1" aria-hidden="true"
                                style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mô Tả Chi Tiết</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <span id="hienChiTiet"></span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Sửa --}}
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <form id="updateSanPham">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="exampleModalLabel">Cập Nhật Sản
                                                    Phẩm
                                                </h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- <input type="text" name="id" id="id_san_pham_edit" hidden> --}}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Mã sản phẩm</label>
                                                                <input tabindex="1" class="form-control"
                                                                    v-model="edit_sp.ma_san_pham" name="ma_san_pham"
                                                                    id="ma_san_pham_edit" type="text"
                                                                    placeholder="Nhập vào tiêu đề">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tên sản phẩm</label>
                                                                <input tabindex="1" class="form-control"
                                                                    name="ten_san_pham" id="ten_san_pham_edit" v-on:keyup="chuyenDoiSlugEdit()"
                                                                    v-model="edit_sp.ten_san_pham" type="text"
                                                                    placeholder="Nhập vào tiêu đề">


                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Slug sản phẩm</label>
                                                                <input tabindex="1" class="form-control"
                                                                    name="slug_san_pham" id="slug_san_pham_edit"
                                                                    v-model="edit_sp.slug_san_pham" type="text"
                                                                    placeholder="Nhập vào tiêu đề">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Giá</label>
                                                                <input tabindex="1" class="form-control" name="gia"
                                                                    v-model="edit_sp.gia" id="gia_edit"
                                                                    type="text" placeholder="Nhập vào tiêu đề">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Giá khuyến mãi</label>
                                                                <input tabindex="1" class="form-control"
                                                                    name="gia_khuyen_mai" id="gia_khuyen_mai_edit"
                                                                    v-model="edit_sp.gia_khuyen_mai" type="text"
                                                                    placeholder="Nhập vào tiêu đề">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Số lượng</label>
                                                                <input tabindex="3" class="form-control"
                                                                    name="so_luong" id="so_luong_edit" type="number"
                                                                    v-model="edit_sp.so_luong"
                                                                    placeholder="Nhập số lượng sản phẩm">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Danh mục</label>
                                                                <select name="ma_danh_muc_id" id="ma_danh_muc_id_edit"
                                                                    v-model="edit_sp.ma_danh_muc_id" class="form-control">
                                                                    <template v-for="(v, k) in list_dm">
                                                                        <option v-bind:value="v.id"> @{{ v.ten_danh_muc }}</option>
                                                                    </template>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Chi tiết</label>
                                                                <textarea v-model="edit_sp.chi_tiet" name="chi_tiet" id="chi_tiet_edit" cols="30" rows="5"
                                                                    class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label>Hình Ảnh</label>
                                                                <div class="input-group">
                                                                    <input name="hinh_anh_update" id="hinh_anh_update" class="form-control" type="text" name="filepath">
                                                                    <span class="input-group-prepend">
                                                                        <a id="lfm_edit" data-input="hinh_anh_update" data-preview="holder_update" class="btn btn-primary">
                                                                            <i class="fa fa-picture-o"></i> Choose
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                                <div id="holder_update" class="img-fluid" style="margin-top: 15px; max-width: 100%; height: auto;"></div>


                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Trạng Thái</label>
                                                                <select tabindex="8" name="is_open" id="is_open_edit"
                                                                    v-model="edit_sp.is_open" class="form-control">
                                                                    <option value=1>Hiển thị</option>
                                                                    <option value=0>Tạm tắt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="button"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button class="btn btn-secondary" type="button" v-on:click="updateSanPham()">Lưu Thay
                                                            Đổi</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            {{-- Xóa --}}
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Xoá sản phẩm</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-primary" role="alert">
                                                Bạn có chắc chắn muốn xóa sản phẩm: <b class="text-danger text-uppercase">@{{delete_sp.ten_san_pham}}</b> này không?
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="button"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button v-on:click="deleteSanPham()" class="btn btn-secondary" type="button"
                                                data-bs-dismiss="modal">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list_dm             : [],
                list_sp             : [],
                modal               : {},
                slug                : '',
                ma_san_pham         : '',
                ten_san_pham        : '',
                message_ma_san_pham : '',
                message_ten_san_pham : '',
                message_slug_san_pham : '',
                delete_sp           : {},
                edit_sp             : {},
                key_search          : '',
            },
            created() {
                this.loadData();
                this.loadDanhMuc();
            },
            methods: {
                addSP() {
                    var paramObj = {};
                    $.each($('#createSanPham').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    axios
                        .post('/admin-shop/san-pham/create', paramObj)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                $('#createSanPham').trigger('reset');
                                $('#modalSanPham').modal('hide');
                                this.ten_san_pham = '',
                                this.slug = '',
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                loadData() {
                        axios
                            .get('/admin-shop/san-pham/data')
                            .then((res) => {
                                this.list_sp = res.data.data;
                            });
                },
                changeIsOpen(id) {
                    axios
                        .get('/admin-shop/san-pham/update-status/' + id)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            var listError = res.response.data.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        });
                },
                deleteSanPham() {
                    axios
                        .get('/admin-shop/san-pham/destroy/' + this.delete_sp.id)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                updateSanPham(){
                    this.edit_sp.hinh_anh =$("#hinh_anh_update").val();
                    axios
                        .post('/admin-shop/san-pham/update', this.edit_sp)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(`Đã cập nhật ${this.edit_sp.ten_san_pham} thành công!`);
                                $('#editModal').modal('hide');
                                this.loadData();
                            }
                            else{
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                search(){
                    var payload = {
                        'key_search' : this.key_search,
                    };
                    axios
                        .post('/admin-shop/san-pham/search', payload)
                        .then((res) => {
                            if(res.data.status) {
                                this.list_sp = res.data.data;
                            } else {
                                toastr.error(res.data.message);
                            }

                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                checkMaSanPham() {
                    if (this.ma_san_pham === '') {
                        this.message_ma_san_pham = "Mã sản phẩm không được để trống!";
                        $("#message_ma_san_pham").addClass("text-danger");
                        $("#ma_san_pham").removeClass("border border-danger");
                        $("#ma_san_pham").addClass("border border-danger");
                        return;
                    }
                    var payload = {
                        'ma_san_pham': this.ma_san_pham,
                    };
                    axios.post('/admin-shop/san-pham/check-product-id', payload)
                        .then((res) => {
                            // Nếu true nghĩa đỏ và thông báo không được
                            if (res.data.status) {
                                this.message_ma_san_pham = "Mã sản phẩm đã tồn tại!";
                                $("#message_ma_san_pham").addClass("text-danger");
                                $("#ma_san_pham").removeClass("border border-danger");
                                $("#ma_san_pham").addClass("border border-danger");
                            } else {
                                this.message_ma_san_pham = "Mã sản phẩm có thể tạo!";
                                $("#message_ma_san_pham").removeClass("text-danger");
                                $("#message_ma_san_pham").addClass("text-primary");
                                $("#ma_san_pham").removeClass("border border-danger");
                                $("#ma_san_pham").addClass("border border-primary");
                            }
                        })
                        .catch((error) => {
                            var listError = error.response.data.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        });
                },
                checkTenSanPham() {
                    if (this.ten_san_pham === '') {
                        this.message_ten_san_pham = "Tên sản phẩm không được để trống!";
                        $("#message_ten_san_pham").addClass("text-danger");
                        $("#ten_san_pham").removeClass("border border-danger");
                        $("#ten_san_pham").addClass("border border-danger");
                        return;
                    }
                    var payload = {
                        'ten_san_pham': this.ten_san_pham,
                    };

                    axios.post('/admin-shop/san-pham/check-product-id2', payload)
                        .then((res) => {
                            // Nếu true nghĩa đỏ và thông báo không được
                            if (res.data.status) {
                                this.message_ten_san_pham = "Tên sản phẩm đã tồn tại!";
                                $("#message_ten_san_pham").addClass("text-danger");
                                $("#ten_san_pham").removeClass("border border-danger");
                                $("#ten_san_pham").addClass("border border-danger");
                            } else {
                                this.message_ten_san_pham = "Tên sản phẩm có thể tạo!";
                                $("#message_ten_san_pham").removeClass("text-danger");
                                $("#message_ten_san_pham").addClass("text-primary");
                                $("#ten_san_pham").removeClass("border border-danger");
                                $("#ten_san_pham").addClass("border border-primary");
                            }
                        })
                        .catch((error) => {
                            var listError = error.response.data.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        });
                },

                checkSlugSanPham() {
                    if (this.slug === '') {
                        this.message_slug_san_pham = "Slug sản phẩm không được để trống!";
                        $("#message_slug_san_pham").addClass("text-danger");
                        $("#slug_san_pham").removeClass("border border-danger");
                        $("#slug_san_pham").addClass("border border-danger");
                        return;
                    }
                    var payload = {
                        'slug_san_pham': this.slug,
                    };

                    axios.post('/admin-shop/san-pham/check-product-slug', payload)
                        .then((res) => {
                            // Nếu true nghĩa đỏ và thông báo không được
                            if (res.data.status) {
                                this.message_slug_san_pham = "Slug sản phẩm đã tồn tại!";
                                $("#message_slug_san_pham").addClass("text-danger");
                                $("#slug_san_pham").removeClass("border border-danger");
                                $("#slug_san_pham").addClass("border border-danger");
                            } else {
                                this.message_slug_san_pham = "Slug sản phẩm có thể tạo!";
                                $("#message_slug_san_pham").removeClass("text-danger");
                                $("#message_slug_san_pham").addClass("text-primary");
                                $("#slug_san_pham").removeClass("border border-danger");
                                $("#slug_san_pham").addClass("border border-primary");
                            }
                        })
                        .catch((error) => {
                            var listError = error.response.data.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        });
                },
                loadDanhMuc() {
                    axios
                        .get('/admin-shop/danh-muc/data')
                        .then((res) => {
                            this.list_dm = res.data.data;
                        });
                },
                showUpdate(v) {
                    this.edit_sp = Object.assign({}, v);
                    $("#hinh_anh_update").val(v.hinh_anh);
                    var images = v.hinh_anh.split(",");
                    var text = "";
                    for (var i = 0; i < images.length; i++) {
                    text += '<img src="'+ images[i] + '" style="margin-top:15px;max-height:100px;">';
                    }
                    $("#holder_update").html(text);
                    // $("#hinh_anh_update").val(v.hinh_anh).split(",");
                    // var text = '<img src="'+ v.hinh_anh + '" style="margin-top:15px;max-height:100px;">'
                    // $("#holder_update").html(text);
                },
                converToSlug(str) {
                    str = str.toLowerCase();

                    str = str
                        .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                        .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

                    // Thay ký tự đĐ
                    str = str.replace(/[đĐ]/g, 'd');

                    // Xóa ký tự đặc biệt
                    str = str.replace(/([^0-9a-z-\s])/g, '');

                    // Xóa khoảng trắng thay bằng ký tự -
                    str = str.replace(/(\s+)/g, '-');

                    // Xóa ký tự - liên tiếp
                    str = str.replace(/-+/g, '-');

                    // xóa phần dư - ở đầu & cuối
                    str = str.replace(/^-+|-+$/g, '');

                    // return
                    return str;
                },

                chuyenDoiSlug() {
                    this.slug = this.converToSlug(this.ten_san_pham);
                },
                chuyenDoiSlugEdit() {
                    this.edit_sp.slug_san_pham = this.converToSlug(this.edit_sp.ten_san_pham);
                },
                stringToArray(str) {
                    return str.split(",");
                },
                hienChiTiet() {
                    $('#hienChiTiet').html(this.modal.chi_tiet);
                },
                formatPrice(value) {
                    let val = (value / 1).toFixed(0).replace('.', ',')
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                },
            },
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.19.1/ckeditor.js"></script>
    {{-- <script>
    CKEDITOR.replace('mo_ta');
    // CKEDITOR.replace('mo_ta_edit');
</script> --}}
    <script>
        var route_prefix = "/laravel-filemanager";
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $("#lfm").filemanager('image', {
            prefix: route_prefix
        });
        $("#lfm_edit").filemanager('image', {
            prefix: route_prefix
        });
    </script>
@endsection
