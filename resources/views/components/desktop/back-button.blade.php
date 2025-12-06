@props(['showOnMobile' => true])

@if($showOnMobile)
<div class="back-button-container d-none d-sm-block">
    <button onclick="history.back()" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-chevron-left"></i> Voltar
    </button>
</div>
@endif

<style>
.back-button-container {
    padding: 1rem;
    background: white;
    border-bottom: 1px solid #e9ecef;
    display: none !important;
}

@media (max-width: 576px) {
    .back-button-container {
        display: block !important;
    }
}
</style>
