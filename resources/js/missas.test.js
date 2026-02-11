/**
 * Testes unitários para funções de cálculo de horário de missas
 * 
 * Implementado conforme recomendações do relatório técnico
 * usando Vitest como framework de testes
 */
import { describe, it, expect } from 'vitest';
import { calcularProximaMissa } from './app.js';

describe('calcularProximaMissa', () => {
    it('deve retornar um objeto com as propriedades dia, horario e data', () => {
        const resultado = calcularProximaMissa();
        
        // Verifica se o resultado não é null
        expect(resultado).not.toBeNull();
        
        // Verifica se contém todas as propriedades esperadas
        expect(resultado).toHaveProperty('dia');
        expect(resultado).toHaveProperty('horario');
        expect(resultado).toHaveProperty('data');
    });
    
    it('deve retornar uma data futura', () => {
        const resultado = calcularProximaMissa();
        const agora = new Date();
        
        // Verifica se o resultado não é null
        expect(resultado).not.toBeNull();
        
        // Verifica se a data retornada é no futuro
        expect(resultado.data).toBeInstanceOf(Date);
        expect(resultado.data.getTime()).toBeGreaterThan(agora.getTime());
    });
    
    it('deve retornar um horário válido no formato HH:MM', () => {
        const resultado = calcularProximaMissa();
        
        // Verifica se o resultado não é null
        expect(resultado).not.toBeNull();
        
        // Verifica se o horário está no formato correto (HH:MM)
        expect(resultado.horario).toMatch(/^\d{2}:\d{2}$/);
    });
    
    it('deve retornar um dia válido', () => {
        const resultado = calcularProximaMissa();
        const diasValidos = ['hoje', 'domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'];
        
        // Verifica se o resultado não é null
        expect(resultado).not.toBeNull();
        
        // Verifica se o dia está na lista de dias válidos
        expect(diasValidos).toContain(resultado.dia);
    });
});
