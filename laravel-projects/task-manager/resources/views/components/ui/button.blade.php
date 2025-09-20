@props([
  "title" => "",
  "variant" => "default",
  //default,
  destructive,
  outline,
  secondary,
  ghost,
  link"size" => "default",
  //default,
  sm,
  lg,
  icon"link" => false,
  //Iftrue,
  renderasananchortag,
])

@php
  $base = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4 [&_svg]:shrink-0';

  $variants = [
    "default" => "bg-primary text-primary-foreground hover:bg-primary/90",
    "destructive" => "bg-destructive text-destructive-foreground hover:bg-destructive/90",
    "outline" => "border bg-background shadow-xs hover:bg-accent/60 hover:text-accent-foreground dark:bg-input/30 dark:border-input",
    "secondary" => "bg-secondary text-secondary-foreground hover:bg-secondary/80",
    "ghost" => "hover:bg-accent hover:text-accent-foreground",
    "link" => "text-primary underline-offset-4 hover:underline",
  ];

  $sizes = [
    "default" => "h-10 px-4 py-2",
    "sm" => "h-8 rounded-md px-3",
    "lg" => "h-11 rounded-xl px-6",
    "icon" => "size-10",
  ];

  $finalClasses = trim("$base " . ($variants[$variant] ?? $variants["default"]) . " " . ($sizes[$size] ?? $sizes["default"]));
@endphp

@if ($link)
  <a data-ui-button {{ $attributes->merge(["class" => "$finalClasses"]) }}>
    @php($hasSlot = isset($slot) && trim($slot) !== "")
    @if ($hasSlot)
      {{ $slot }}
    @else
      {{ $title }}
    @endif
  </a>
@else
  <button
    data-ui-button
    {{ $attributes->merge(["class" => "$finalClasses"]) }}
  >
    @php($hasSlot = isset($slot) && trim($slot) !== "")
    @if ($hasSlot)
      {{ $slot }}
    @else
      {{ $title }}
    @endif
  </button>
@endif
