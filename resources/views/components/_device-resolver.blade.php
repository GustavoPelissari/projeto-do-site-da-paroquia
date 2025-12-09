@php
    // Resolve qual versao do componente carregar com base no user agent
    $componentName = $component ?? null;

    if (!$componentName) {
        return;
    }

    $userAgent = request()->header('User-Agent', '');
    $mobilePattern = '/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobile/i';
    $isMobile = preg_match($mobilePattern, $userAgent) === 1;

    $mobileView = "components.mobile.{$componentName}";
    $desktopView = "components.desktop.{$componentName}";
    $viewToRender = $isMobile && view()->exists($mobileView)
        ? $mobileView
        : $desktopView;
@endphp

@includeIf($viewToRender)
