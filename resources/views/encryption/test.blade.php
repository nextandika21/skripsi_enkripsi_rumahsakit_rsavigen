@extends('layouts.master')
@section('title', 'Test Encryption')

@section('content')
    <div class="grid_12">
        <div class="widget_wrap">
            <div class="widget_top">
                <span class="h_icon blocks_images"></span>
                <h6>@yield('title')</h6>
            </div>
            <div class="widget_content">
                <form class="form_container left_label" autocomplete="off">
                    <ul>
                        <li>
                            <div class="form_grid_12">
                                <label>Hasil Enkripsi : <b><span id="hasilEnkrip"></span></b></label>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <label class="field_title">Plaintext</label>
                                <div class="form_input">
                                    <input id="plaintext" name="plaintext" type="text" tabindex="1" placeholder="Type plaintext here">
                                    <div class="btn_30_blue">
                                        <a href="#" title="Encrypt" onclick="Encrypt()"><span class="icon lock_co"></span><span class="btn_link">Encrypt</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <label>Hasil Dekripsi : <b><span id="hasilDekrip"></span></b></label>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <label class="field_title">Ciphertext</label>
                                <div class="form_input">
                                    <input id="ciphertext" name="ciphertext" type="text" tabindex="1" placeholder="Type ciphertext here">
                                    <div class="btn_30_blue">
                                        <a href="#" title="Decrypt" onclick="Decrypt()"><span class="icon lock_unlock_co"></span><span class="btn_link">Decrypt</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function Encrypt(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var plaintext = document.getElementById("plaintext").value;
            $.ajax({
                /* the route pointing to the post function */
                url: 'test/enkripsi',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    plaintext: plaintext
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function(data) {
                    document.getElementById("hasilEnkrip").innerHTML = data;
                }
            });
        }

        function Decrypt(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var ciphertext = document.getElementById("ciphertext").value;
            $.ajax({
                /* the route pointing to the post function */
                url: 'test/dekripsi',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {
                    _token: CSRF_TOKEN,
                    ciphertext: ciphertext
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function(data) {
                    document.getElementById("hasilDekrip").innerHTML = data;
                }
            });
        }
    </script>
@stop