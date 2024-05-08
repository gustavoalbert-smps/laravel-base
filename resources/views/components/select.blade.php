@props(['disabled' => false, 'selected' => null, 'options' => []])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    @if (empty($options))
        <option value="" disabled>Select a Option</option>
    @else
        @foreach ($options as $key => $option)
        <option value="{{$key}}" {{$selected == $key ? 'selected' : ''}}>{{$option}}</option>    
        @endforeach
    @endif
<select>
