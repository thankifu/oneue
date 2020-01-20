@extends('frontend.common.index')

@section('style')
@endsection

@section('body')

<div class="container star-user star-mb-25">
    <ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/user">用户中心</a></li>
        <li class="active">头像修改</li>
    </ol>
    <div class="row">

        <div class="col-md-3 star-side hidden-sm hidden-xs">
            @include('frontend.user.side')
        </div>

        <div class="col-md-9 star-main">
            <div class="row">
                <form id="upload_form" target="upload_iframe" enctype="multipart/form-data" action="/upload/index" method="post" style="display:none;">
                    {{csrf_field()}}
                    <input type="file" name="upload_file" id="upload_file" onchange="starUpload()">
                    <input type="hidden" name="upload_place" id="upload_place" value="">
                    <input type="hidden" name="upload_object" id="upload_object" value="">
                    <iframe name="upload_iframe" id="upload_iframe" style="display: none;"></iframe>
                </form>
                <form id="form" class="text-center">
                    {{csrf_field()}}
                    <p onclick="starPicture('avatar', 'avatar')" style="cursor:pointer">
                        <img src="{{$user['avatar']}}" alt="{{$user['username']}}" class="img-circle" width="100"/>
                    </p>
                    <p>点击头像修改</p>
                    <input type="hidden" id="avatar" name="avatar" value=""/>
                    <button type="button" class="btn btn-primary" onclick="starAvatarStore();" style="margin:0;">保存</button>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection