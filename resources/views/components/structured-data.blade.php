@props(['type' => 'organization', 'data' => null])

@php
    use App\Services\StructuredDataService;
    
    $json = '';
    
    if ($type === 'organization') {
        $json = StructuredDataService::organization();
    } elseif ($type === 'event' && isset($data)) {
        $json = StructuredDataService::event($data);
    } elseif ($type === 'article' && isset($data)) {
        $json = StructuredDataService::article($data);
    } elseif ($type === 'breadcrumbs' && isset($data)) {
        $json = StructuredDataService::breadcrumbs($data);
    }
@endphp

@if ($json)
    <script type="application/ld+json">
        {!! $json !!}
    </script>
@endif
