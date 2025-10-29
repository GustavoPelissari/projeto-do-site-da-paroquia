// Script para gerenciar imagens de São Paulo Apóstolo
document.addEventListener('DOMContentLoaded', function() {
    // Função para tratar erros de carregamento de imagem
    function handleImageError(img) {
        console.log('Imagem não encontrada, usando fallback SVG');
        
        // Tenta carregar o SVG como fallback
        const svgUrl = img.src.replace('.png', '.svg');
        const tempImg = new Image();
        
        tempImg.onload = function() {
            img.src = svgUrl;
        };
        
        tempImg.onerror = function() {
            // Se nem o SVG funcionar, esconde a imagem e mostra o ícone
            img.style.display = 'none';
            const parent = img.parentElement;
            const iconFallback = parent.querySelector('.paulo-logo-icon, .paulo-hero-icon');
            if (iconFallback) {
                iconFallback.style.display = 'flex';
            }
        };
        
        tempImg.src = svgUrl;
    }
    
    // Adiciona tratamento de erro para todas as imagens do santo
    const saintImages = document.querySelectorAll('.paulo-saint-image, .paulo-hero-saint-image');
    saintImages.forEach(function(img) {
        img.addEventListener('error', function() {
            handleImageError(this);
        });
        
        // Verifica se a imagem já falhou ao carregar
        if (img.naturalWidth === 0 && img.complete) {
            handleImageError(img);
        }
    });
});

// Função para precarregar as imagens
function preloadSaintImages() {
    const images = [
        '/images/sao-paulo-apostolo.png',
        '/images/sao-paulo-apostolo.svg'
    ];
    
    images.forEach(function(src) {
        const img = new Image();
        img.src = src;
    });
}

// Precarrega as imagens quando a página carrega
window.addEventListener('load', preloadSaintImages);