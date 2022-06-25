@php
$searchParam = '';
// $totalCount;
// $perPage = 18
$totalPage = ceil($totalCount / $perPage);
$sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1;
foreach($_GET as $key => $value):
    if($key == 'category'):
        $searchParam .= http_build_query(['category' => $_GET['category']]) . '&';
        continue;
    endif;
  



    
    if($key == 'sayfa'):
    else:
        $searchParam .= $key . '=' .$value . '&';
    endif;
endforeach;
@endphp
@if($totalPage <= 0)

@else
    <ul class="pagination" role="navigation">
    <li class="page-item disabled" aria-disabled="true" aria-label="« Önceki">
        <span class="page-link" aria-hidden="true">‹</span>
    </li>
    @for($i = 1; $i <= $totalPage; $i++)
        @if($i == $sayfa)
        <li class="page-item" aria-current="page"><span class="page-link {{$i == $sayfa ? 'active' : ''}}">{{$i}}</span></li>
        @else
        <li class="page-item"><a class="page-link" href="
@if(!isset($page) && empty($page))
            {{route('search.spagetti', [request()->category,request()->start_date,request()->end_date, $searchParam, 'sayfa=' . $i])}}
@else
          {{url('/'.$page.'?'.$searchParam.'sayfa='.$i)}}
@endif            ">{{$i}}</a></li>
        @endif
    @endfor
    <li class="page-item">
        <a class="page-link" href="
@if(!isset($page) && empty($page))
        {{route('search.no-date', [request()->category, $searchParam, 'sayfa=' . ($sayfa + 1) ])}}
@else
        {{  url('/'.$page.'?'.$searchParam.'sayfa=' . ($sayfa + 1))}}
@endif
        " rel="next" aria-label="Sonraki »">›</a>
    </li>

    </ul>

@endif
