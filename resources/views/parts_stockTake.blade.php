@extends('template')
@include('navtop')
@section('content')
<div class="container" id="parts_upload">
    @if(Auth::check())
        <input type="hidden" value="{{Auth::User()->shop_id}}" class="shop_id">
        <div class="file-field input-field">
            <div class="btn">
                <span>Upload</span>
                <input type="file" id="file" v-on:change="fileUpload()">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
                <p class="right filesize" style="font-style:italic">@{{filesize_content}}</p>
            </div>
        </div>
    @endif
</div>
@stop

@push('parts_stockTake')
<script type="text/javascript">
	console.log()
    var parts_upload = new Vue({
        el:'#parts_upload',
        data:{
            file:'',
            filesize_content:'',
            shop_id:''
        },
        methods:{
            fileUpload:function(){
                this.filesize_content = '';
                var input;
                // (Can't use `typeof FileReader === "function"` because apparently
                // it comes back as "object" on some browsers. So just see if it's there
                // at all.)
                if (!window.FileReader) {
                    alert("The file API isn't supported on this browser yet.");
                    return;
                }
                input = document.getElementById('file');
                if (!input) {
                    alert("Um, couldn't find the uploaded file element.");
                }
                else if (!input.files) {
                    alert("This browser doesn't seem to support the `files` property of file inputs.");
                }
                else if (!input.files[0]) {
                    alert("Please select a file before clicking 'Load'");
                }
                else {
                    this.file = input.files[0];
                    this.filesize_content = `${this.file.size} bytes`;
                    let formData = new FormData();
                    formData.append('parts_stockTake_sheet',this.file);
                    formData.append('shop_id',document.querySelector('.shop_id').value)
                    axios({
                        method:'post',
                        url:stockMan_api+'uploaded-part-stocktake-sheet',
                        data:formData,
                        headers:{
                            'Content-Type': 'multipart/form-data',
                        }
                    }).then((e)=>console.log(e.data))
                }

            }
        }
    })
</script>
@endpush
