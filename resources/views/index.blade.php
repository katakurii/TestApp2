@extends('layouts.app')
@section('content')
<style type="text/css">
    .textt{
        font-size:12px;
        display: block;
    }
    @media only screen and (max-width: 992px) {
        .container {
            width: auto;
        }
        .textt{
            margin-left: 5%;
        }
}
    @media only screen and (max-width: 768px) {
        /*.textt{
            margin-left: 10%;
        }*/
    }
</style>
    <div class="container">
        <div class="row">
        @foreach($model as $item)
            <div class="col-md-3 col-xs-12 col-sm-6" style="margin-bottom:30px;">
                    <!-- <div class="col-md-12"> -->
                    <div style=" border: 1px solid #e4e2e2;background-color: #f1f0f0;">
                        <div class="form-group" style="height: 200px; text-align: center; overflow: hidden;">
                            <a href="{{ url('/detail/'. $item->id)}}"><img src="/images/{{ $item->photo }}" class="img" style="height: 200px;"  /></a>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="col-md-12"> -->
                        <div class="form-group textt" style="margin-left: 10px;overflow: hidden;">
                            <span style="color:#004b91;font-weight:bold;" class="textt">{{ str_limit($item->name, $limit = 10, $end = '...')}}</span>
                            <span style="color:#2a2a2a;" class="textt">Price: <span style="color:#bf2151">{{number_format($item->price)}}</span></span>
                            <span style="color:#2a2a2a;" class="textt">{{ str_limit($item->description, $limit = 10, $end = '...')}}</span>
                        </div>
                    </div>
                   
            </div>
        @endforeach
        </div>
        <!-- end product -->
    </div>
    <div class="container">
        {{ $model->links() }}
    </div>
@endsection
