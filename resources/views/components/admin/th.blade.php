@props(['rowspan' => null, 'colspan' => null])
<th {{ $attributes->merge(['class' => 'text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7']) }}
    rowspan="{{ $rowspan }}" colspan="{{ $colspan }}">
    {{ $slot }}
</th>
