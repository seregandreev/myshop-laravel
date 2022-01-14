<h1>
    {{ $title }}
</h1>

<ul>
@foreach ($numbers as $number)
    <li>
        {{ $number }}
        @if($loop->first)
            (это первая запись)
        @endif
        @if($loop->last)
            (это последняя запись)
        @endif
    </li>
     @php $cnt = $loop->count @endphp
@endforeach
</ul>
Всего записей - {{ $cnt }}

<ul>
    @for($i = 0; $i < 5; $i++)
        <li>
            {{ $i }}
        </li>
    @endfor
</ul>