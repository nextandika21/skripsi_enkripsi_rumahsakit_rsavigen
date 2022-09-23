@extends('layouts.master')
@section('title', 'Key Generator')

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
                                <label class="field_title">Tanggal Update</label>
                                <div class="form_input">
                                    <span><b>{{$tanggal_update}}</b></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <label class="field_title">Diupdate oleh</label>
                                <div class="form_input">
                                    <span><b>{{$author}}</b></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <div class="btn_30_blue">
                                    <a href="/console/encryption/key/generate" title="Key Generate"><span class="icon arrow_refresh_co"></span><span class="btn_link">Generate Key</span></a>
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
        $(function() {
            var success = '@if (Session::has("success")){{ Session::get("success") }}@endif';
            var error = '@if (Session::has("error")){{ Session::get("error") }}@endif';

            if(success){
                var noty_id = noty({
                    layout : 'top',
                    text: success,
                    modal : true,
                    type : 'success', 
                });
            }
            if(error){
                var noty_id = noty({
                    layout : 'top',
                    text: error,
                    modal : true,
                    type : 'error', 
                });
            }
        });
    </script>
@stop