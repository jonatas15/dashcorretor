<template>
    <div class="relatorio-container">
        <div class="relatorio-a4">
            <header class="relatorio-header">
                <h1>Relatório - Seção 1</h1>
                <p class="data">{{ dataAtual }}</p>
            </header>

            <main class="relatorio-content">
                <section class="secao">
                    <h2>Seção 1</h2>
                    <p>Conteúdo do relatório aqui</p>
                </section>
            </main>

            <footer class="relatorio-footer">
                <p>&copy; 2024 Café Imobiliária</p>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Secao1',
    data() {
        return {
            dataAtual: new Date().toLocaleDateString('pt-BR')
        }
    }
}
</script>

<style scoped>
.relatorio-container {
    display: flex;
    justify-content: center;
    padding: 20px;
    background-color: #f5f5f5;
}

.relatorio-a4 {
    width: 210mm;
    height: 297mm;
    background-color: white;
    padding: 20mm;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #333;
}

.relatorio-header {
    text-align: center;
    border-bottom: 2px solid #333;
    padding-bottom: 15mm;
    margin-bottom: 15mm;
}

.relatorio-header h1 {
    margin: 0;
    font-size: 24pt;
}

.data {
    margin: 5px 0 0 0;
    font-size: 10pt;
    color: #666;
}

.relatorio-content {
    min-height: 200mm;
}

.secao {
    margin-bottom: 10mm;
}

.secao h2 {
    font-size: 14pt;
    margin: 10mm 0 5mm 0;
    color: #222;
}

.secao p {
    font-size: 11pt;
    line-height: 1.6;
    margin: 0;
}

.relatorio-footer {
    margin-top: 15mm;
    padding-top: 10mm;
    border-top: 1px solid #ccc;
    text-align: center;
    font-size: 9pt;
    color: #666;
}
</style>