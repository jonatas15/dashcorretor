<template>
    <div class="relatorio-container">
        <!-- Página A4 para Seção 1 -->
        <div class="relatorio-a4 page-break">
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

        <!-- Página A4 para Seção 2 -->
        <div class="relatorio-a4 page-break">
            <header class="relatorio-header">
                <h1>Relatório - Seção 2</h1>
                <p class="data">{{ dataAtual }}</p>
            </header>

            <main class="relatorio-content">
                <section class="secao">
                    <h2>Seção 2</h2>
                    <p>Mais informações</p>
                </section>
            </main>

            <footer class="relatorio-footer">
                <p>&copy; 2024 Café Imobiliária</p>
            </footer>
        </div>
        <!-- iniciar impressão: -->
        <button @click="printRelatorio">Imprimir Relatório</button>
    </div>
</template>

<script>
export default {
    name: 'Relatoriov2',
    data() {
        return {
            dataAtual: new Date().toLocaleDateString('pt-BR')
        }
    }
}
</script>
<script setup>
    // Botão para Imprimir APENAS as sections - o relatório
    const printRelatorio = () => {
        // imptimir apenas o conteúdo do relatório
        // imprimir todas as divs com a classe relatorio-a4
        const relatorioContent = document.querySelectorAll('.relatorio-a4');
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Relatório</title>');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            .relatorio-a4 {
                width: 210mm;
                height: 297mm;
                background-color: white;
                padding: 20mm;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                position: fixed;
                bottom: 10mm;
                width: calc(100% - 40mm);
            }
        `);
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        relatorioContent.forEach(page => {
            printWindow.document.write(page.outerHTML);
        });
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
        // fecha a janela de impressão após 1 segundo
        setTimeout(() => {
            printWindow.close();
        }, 100);
    };
</script>

<style scoped>
.relatorio-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f5f5f5;
    gap: 20px; /* Espaço entre páginas */
}

.relatorio-a4 {
    width: 210mm;
    height: 297mm;
    background-color: white;
    padding: 20mm;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #333;
    margin-bottom: 20px;
}

.page-break {
    page-break-after: always;
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
    color: #999;
}

@media print {
    .relatorio-container {
        background-color: white;
        padding: 0;
        gap: 0;
    }

    .relatorio-a4 {
        width: 100%;
        height: 100%;
        box-shadow: none;
        padding: 20mm;
        margin: 0;
        page-break-after: always;
    }

    .relatorio-a4:last-child {
        page-break-after: avoid;
    }
}
</style>