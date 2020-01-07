@extends('frontend.common.index')

@section('style')
<link rel="stylesheet" href="/packages/highlight/styles/dracula.css" type="text/css" media="all" />
@endsection

@section('body')

<div class="container star-item-article star-mb-25">
	<ol class="breadcrumb">
        <li><a href="/">首页</a></li>
        <li><a href="/article">文章</a></li>
        @if(isset($category))
        @if(!empty($category))
        <li><a href="/article/category/{{$category['id']}}">{{$category['name']}}</a></li>
        @endif
        <li class="active">{{$article['title']}}</li>
        @endif
    </ol>
    <div class="row">
        <div class="col-md-9 star-main">
            <div class="star-info">
                <div class="star-title"><h1>{{$article['title']}}</h1></div>
                <div class="star-meta">
                    <span>{{$article['created']?date('Y-m-d H:i:s',$article['created']):'-'}}</span>
                </div>
                <div class="star-details">

                    {!!$article['content']!!}

                </div>
            </div>
        </div>

        @include('frontend.common.side')

	</div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="/packages/highlight/highlight.pack.js"></script>
<script type="text/javascript">
    hljs.initHighlightingOnLoad();

    $("code").each(function(){
      $(this).html("<ul><li>" + $(this).html().replace(/\n/g,"\n</li><li>") +"\n</li></ul>");
    });
</script>
@endsection