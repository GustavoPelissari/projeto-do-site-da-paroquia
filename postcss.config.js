export default {
    plugins: [
        // Bootstrap-only:
        // Carrega autoprefixer apenas se estiver instalado (evita crash no Vite)
        (() => {
            try {
                return require('autoprefixer');
            } catch (e) {
                return null;
            }
        })(),
    ].filter(Boolean),
};
