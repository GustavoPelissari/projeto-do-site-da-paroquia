import { defineConfig } from 'vite';
import { configDefaults } from 'vitest/config';

/**
 * Configuração do Vitest para testes unitários JavaScript
 * 
 * Integra-se com a configuração Vite existente do Laravel
 * e define jsdom como ambiente para suportar testes que usam DOM
 */
export default defineConfig({
    test: {
        // Usa jsdom para simular ambiente de navegador
        environment: 'jsdom',
        
        // Arquivos de teste
        include: ['resources/js/**/*.test.js'],
        
        // Configurações padrão
        globals: true,
    },
});
