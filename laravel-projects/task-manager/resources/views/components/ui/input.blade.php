@props(['label' => null, 'id' => null, 'name' => null ])

<div>
    <label for="{{$id}}" class="block text-sm mb-2 ">{{$label}}</label>
    <div class="relative">
        <input {{$attributes}} >
    </div>
    @error($name)<p class="text-xs text-red-600 mt-2">{{$message}}</p>@enderror
</div>
