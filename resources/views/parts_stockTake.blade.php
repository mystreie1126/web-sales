@extends('template')
@include('navtop')
@section('content')
<div class="container" id="parts_upload">
    @if(Auth::check())
        <input type="hidden" value="{{Auth::User()->shop_id}}" class="shop_id">
        <div class="file-field input-field">
            <div class="btn" :disabled="disabled">
                <span>Upload</span>
                <input type="file" id="file" v-on:change="fileUpload()" :disabled="disabled">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" :disabled="disabled">
                <p class="right filesize" style="font-style:italic">@{{filesize_content}}</p>
            </div>
            <p class="center">@{{message}}</p>
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
            shop_id:'',
            disabled:'',
            message:''
        },
        created(){
            this.check();
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
                    this.disabled = true;
                    this.message = 'Uploading... please do not refresh the page...Zzzz'
                    this.file = input.files[0];
                    this.filesize_content = `${this.file.size} bytes`;
                    let formData = new FormData();
                    formData.append('parts_stockTake_sheet',this.file);
                    formData.append('shop_id',document.querySelector('.shop_id').value)
                    axios({
                        method:'post',
                        url:stockMan_api+'parts-stocktake-upload',
                        data:formData,
                        headers:{
                            'Content-Type': 'multipart/form-data',
                        }
                    }).then((e)=>{
                        console.log(e)
                        if(e.data.status == 'success'){
                            console.log('ahahah')
                            location.reload();
                        }else if (e.data.status == 'failed'){
                            this.disabled = false;
                            this.message= e.data.data.message;
                        }
                    }).catch((e)=>{
                        this.check();
                        location.reload();
                    })
                }
            },
            check:function(){
                axios({
                    method:'get',
                    url:stockMan_api+'parts-stocktake-upload/check/'+document.querySelector('.shop_id').value
                }).then((e)=>{
                    let res = e.data;
                    console.log(res)
                    //allow to upload nothing being check
                    if(res.status == 'success' && res.data.flag == 'upload'){
                        this.disabled = false;
                        this.message = res.data.msg
                    }
                    //lock upload after 1st time upload 
                    else if(res.status == 'success' && res.data.flag == 'checkingByKeiran'){
                        this.disabled = true;
                        this.message = res.data.msg
                    }
                    //give double check
                    else if(res.status == 'success' && res.data.flg == 'doublecheck'){
                        this.disabled = true;
                        this.message = res.data.msg
                    }
                })
            }
        }
    })
</script>
@endpush
