<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahfudz Khoirun Nizam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        tr.active {
            background: springgreen;
        }

        #btn-close {
            cursor: pointer;
        }
    </style>
</head>

<body>


    <div class="container py-4">
        <h1 class="fs-4">Produk</h1>
        <div class="card" id="v-index">
            <div class="card-header">

            </div>

            <div class="card-body">
                <div class="row">


                    <div class="col-md-4">
                        <div class="card bg-info px-3 py-3">
                            <div class="text-end"><i id="btn-close"
                                    class="d-none fa fa-close btn btn-sm btn-danger"></i></div>
                            <form>
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <input name="nama_produk" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <input name="harga" type="number" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Jumlah</label>
                                    <input name="jumlah" type="number" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"></textarea>
                                </div>


                                <button type="button" class="btn btn-secondary float-end mt-3"
                                    onClick="simpan_produk(this)"> Tambah</button>
                            </form>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <table class="table  table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>


    </div>

    <div class="modal fade" id="modal-hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Hapus Data Produk ?</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-hapus" class="btn btn-primary">Hapus</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"
        integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.3/axios.min.js"
        integrity="sha512-L4lHq2JI/GoKsERT8KYa72iCwfSrKYWEyaBxzJeeITM9Lub5vlTj8tufqYk056exhjo2QDEipJrg6zen/DDtoQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(async () => {
            get_data()

        })

        let id_update;
        let is_update = false;


        const get_data = async () => {
            await axios.get(`{{url('api/produk')}}`)
                .then((res) => {
                    $("table tbody").empty()
                    res.data.data.forEach((produk, i) => {
                        $("table tbody").append(`
                            <tr>
                                <td>${i+1}</td>
                                <td>${produk.nama_produk}</td>
                                <td>${produk.keterangan}</td>
                                <td>${produk.harga}</td>
                                <td>${produk.jumlah}</td>
                                <td> 
                                <button class="btn btn-sm btn-outline-warning" onClick='edit_produk(this,${JSON.stringify(produk)})'><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onClick='hapus_produk("${produk.id}")'><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        `)
                    })
                    if (res.data.data.length == 0) {
                        $("table tbody").append(`
                            <tr><td colspan="6" class="text-center">Tidak Ada Produk</td></tr>
                        `)
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        }

        const post_data = async () => {
            let nama_produk = $("[name='nama_produk']").val()
            let harga = $("[name='harga']").val()
            let jumlah = $("[name='jumlah']").val()
            let keterangan = $("[name='keterangan']").val()
            $("form .is-invalid").removeClass('is-invalid')
            let url = `{{url('api/produk')}}`
            await axios.post(url, {
                    nama_produk,
                    harga,
                    jumlah,
                    keterangan
                })
                .then((res) => {
                    $("form input , form textarea").val('')
                    $.notify("Berhasil Menambah Produk", "success");
                    is_update = false
                    get_data()
                })
                .catch((error) => {
                    $.notify("Field Wajib diisi", "error");
                    for (field in error.response.data.errors) {
                        console.log(field)
                        $(`[name='${field}']`).addClass('is-invalid')
                    }
                })

        }


        const update_data = async () => {
            let nama_produk = $("[name='nama_produk']").val()
            let harga = $("[name='harga']").val()
            let jumlah = $("[name='jumlah']").val()
            let keterangan = $("[name='keterangan']").val()
            $("form .is-invalid").removeClass('is-invalid')
            let url = `{{url('api/produk')}}/${id_update}`
            await axios.patch(url, {
                    nama_produk,
                    harga,
                    jumlah,
                    keterangan
                })
                .then((res) => {
                    $("form input , form textarea").val('')
                    $.notify("Berhasil Mengubah Produk", "success");
                    is_update = false
                    get_data()
                })
                .catch((error) => {
                    $.notify("Field Wajib diisi", "error");
                    for (field in error.response.data.errors) {
                        console.log(field)
                        $(`[name='${field}']`).addClass('is-invalid')
                    }
                })
        }

        const delete_data = async (id) => {
            button_loading($("#btn-hapus"), true)
            axios.delete(`{{url('api/produk')}}/${id}`)
                .then((res) => {
                    $.notify("Berhasil Menghapus Produk", "success");
                    get_data()
                })
                .catch((error) => {
                    $.notify(error, "error");
                })
                .finally(() => {
                    button_loading($("#btn-hapus"), false, "Hapus")
                    $("#modal-hapus").modal("hide")
                })
        }

        const simpan_produk = async (el) => {
            button_loading(el, true)
            is_update ? await update_data() : await post_data()
            button_loading(el, false)
        }

        const edit_produk = (el, data) => {
            $("table tbody .active").removeClass("active")
            $(el).parent().parent().addClass('active')
            $("[name='nama_produk']").val(data.nama_produk)
            $("[name='harga']").val(data.harga)
            $("[name='jumlah']").val(data.jumlah)
            $("[name='keterangan']").val(data.keterangan)
            $("#btn-close").removeClass('d-none')
            $("form button").html('Simpan')
            id_update = data.id
            is_update = true
        }

        const hapus_produk = (id) => {
            $("#modal-hapus").modal("show")
            $("#btn-hapus").attr('onClick', `delete_data(${id})`)
        }

        const button_loading = (el, status, text = is_update ? 'Simpan' : 'Tambah') => {
            is_update ? $("#btn-close").removeClass('d-none') : $("#btn-close").addClass('d-none')
            if (status) {
                $(el).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading..`
                )
                $(el).prop('disabled', true)
            } else {
                $(el).html(text)
                $(el).prop('disabled', false)
            }
        }

        $("#btn-close").on('click', () => {
            $("#btn-close").addClass('d-none')
            is_update = false
            $("table tbody .active").removeClass("active")
            $("form input , form textarea").val('')
        })
    </script>

</body>

</html>