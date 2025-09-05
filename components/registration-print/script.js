app.component('registration-print', {
  template: `
    <div>
      <style>
        .registration-print__button {
            align-items: center;
            background-color: transparent;
            border: none;
            top: -410rem !important;
            color: var(--mc-low-500);
            cursor: pointer;
            display: flex;
            font-size: var(--mc-font-size-xxs);
            gap: .5rem;
            position: absolute;
            right: 48px !important;
        }
        
        .button--primary {
            background-color: var(--mc-primary-500);
            color: white;
            border-radius: 4px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }
        
        .button--icon {
            display: flex;
            align-items: center;
        }
        
        .button--sm {
            font-size: var(--mc-font-size-xs);
            padding: 4px 8px;
        }
        
        /* Estilos para impressão (críticos) */
        @media print {
            body, html {
                overflow: visible !important;
                height: auto !important;
                width: 100% !important;
                background: white !important;
            }
            
            body > *:not(.print-registration-container) {
                display: none !important;
            }
            
            .print-registration-container {
                position: static !important;
                display: block !important;
                width: 100% !important;
                height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
            }
            
            @page {
                size: A4;
                margin: 15mm 15mm 10mm 15mm;
            }
            
            /* Ocultar elementos específicos */
            header, footer, nav, .no-print, .registration-print__button {
                display: none !important;
            }
            
            /* Garantir que iframes sejam visíveis */
            iframe {
                display: block !important;
                overflow: visible !important;
                height: auto !important;
                width: 100% !important;
                border: none !important;
            }
        }
        
        /* Ocultar scroll durante preparação */
        body.printing {
            overflow: hidden !important;
        }
      </style>

      <!-- Botão com a estrutura solicitada -->
      <button 
        class="registration-print__button bold"
        @click="print" 
        :disabled="loading"
      >
        <div class="button button--primary button--icon button--sm">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
               aria-hidden="true" role="img" class="iconify iconify--material-symbols" 
               width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
            <path fill="currentColor" d="M16 8V5H8v3H6V3h12v5zM4 10h16zm14 2.5q.425 0 .713-.288T19 11.5t-.288-.712T18 10.5t-.712.288T17 11.5t.288.713t.712.287M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4zm2-6v-4q0-.425-.288-.712T19 10H5q-.425 0-.712.288T4 11v4h2v-2h12v2z"></path>
          </svg>
          {{ loading ? 'Imprimindo...' : 'Imprimir' }}
        </div>
      </button>

      <!-- Container especial para impressão -->
      <div 
        class="print-registration-container" 
        v-show="showPrint"
      >
        <!-- Conteúdo para impressão -->
        <div class="print-registration">
          <!-- Cabeçalho -->
          <section class="section">
            <div class="registration-header">
              <h1 class="text-center mb-0">Comprovante de Inscrição</h1>
              <div class="registration-meta">
                <div><strong>Inscrição</strong> {{ registration.number }}</div>
                <div><strong>Data</strong> {{ registration.sentTimestamp.date('2-digit year') }}</div>
                <div><strong>Categoria</strong> {{ registration.category }}</div>
                <div><strong>Status</strong> {{ registration.status }}</div>
              </div>
              <div v-if="registration.sentTimestamp" class="text-center text-small">
                Inscrição realizada em {{ registration.sentTimestamp.date('2-digit year') }} às {{ registration.sentTimestamp.time('long') }}
              </div>
            </div>

            <div class="col-12">
              <opportunity-phases-timeline :entity-status="registration.status" center big></opportunity-phases-timeline>
            </div>
          </section>

          <!-- Dados do Proponente -->
          <section class="section">
            <div class="card">
              <h2>Dados do Proponente</h2>
              <mc-summary-agent :entity="registration"></mc-summary-agent>
              <mc-summary-agent-info :entity="registration"></mc-summary-agent-info>
            </div>
          </section>

          <!-- Dados do formulário -->
          <section class="section">
            <div class="card">
              <h2>Dados Informados no Formulário</h2>
              <mc-summary-spaces :entity="registration"></mc-summary-spaces>
              <mc-summary-project :entity="registration"></mc-summary-project>
            </div>
          </section>

          <!-- Fases -->
          <section 
            class="section" 
            v-for="(phase, index) in registration.phases" 
            :key="phase.id"
          >
            <div class="card">
              <h2>{{ phase.name }}</h2>
              <v1-embed-tool route="registrationview" :id="phase.id"></v1-embed-tool>
            </div>
          </section>

          <!-- Marcador para evitar páginas em branco -->
          <div class="end-of-document-marker"></div>
        </div>
      </div>
    </div>
  `,

  props: {
    registration: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      loading: false,
      showPrint: false,
    };
  },

  methods: {
    // SUBSTITUA O MÉTODO print() NO SEU COMPONENTE PELO CÓDIGO ABAIXO

async print() {
  if (this.loading) return;
  this.loading = true;
  this.showPrint = true;

  // Aguardar o Vue renderizar o conteúdo
  await this.$nextTick();
  
  // Função para aplicar estilos de remoção de scrollbar
  const removeScrollbars = (element) => {
    if (element && element.style) {
      element.style.overflow = 'visible';
      element.style.overflowX = 'visible';
      element.style.overflowY = 'visible';
      element.style.scrollbarWidth = 'none';
      element.style.msOverflowStyle = 'none';
    }
  };

  // Remover scrollbars de todos os elementos
  const allElements = document.querySelectorAll('*');
  allElements.forEach(removeScrollbars);

  // Aplicar especificamente no html e body
  removeScrollbars(document.documentElement);
  removeScrollbars(document.body);

  // Forçar ocultação de elementos problemáticos
  const elementsToHide = document.querySelectorAll(`
    header, .header, [role="banner"], .site-header, .page-header, .main-header, .top-header, #header, .masthead,
    nav, .nav, .navbar, .navigation, .menu, .toolbar, .actionbar,
    footer, .footer, .sidebar, .aside, .breadcrumb, .pagination,
    [class*="header"], [id*="header"], [class*="nav"], [id*="nav"],
    .registration-print__button
  `);
  
  const originalStyles = [];
  elementsToHide.forEach((el, index) => {
    originalStyles[index] = {
      display: el.style.display,
      visibility: el.style.visibility,
      position: el.style.position,
      left: el.style.left,
      top: el.style.top,
      width: el.style.width,
      height: el.style.height,
      opacity: el.style.opacity,
      overflow: el.style.overflow,
      overflowX: el.style.overflowX,
      overflowY: el.style.overflowY,
    };
    
    // Aplicar múltiplas camadas de ocultação
    el.style.display = 'none';
    el.style.visibility = 'hidden';
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    el.style.top = '-9999px';
    el.style.width = '0';
    el.style.height = '0';
    el.style.opacity = '0';
    el.style.overflow = 'hidden';
  });

  // Aplicar estilos específicos para impressão no container principal
  const printContainer = document.querySelector('.print-registration-container, .print-registration');
  if (printContainer) {
    printContainer.style.overflow = 'visible';
    printContainer.style.overflowX = 'visible';
    printContainer.style.overflowY = 'visible';
    printContainer.style.scrollbarWidth = 'none';
    printContainer.style.msOverflowStyle = 'none';
  }

  // Remover scrollbars de iframes especificamente
  const iframes = document.querySelectorAll('iframe');
  iframes.forEach(iframe => {
    iframe.style.overflow = 'visible';
    iframe.style.scrollbarWidth = 'none';
    iframe.style.msOverflowStyle = 'none';
    
    // Tentar acessar o conteúdo do iframe (se possível)
    try {
      if (iframe.contentDocument) {
        const iframeBody = iframe.contentDocument.body;
        const iframeHtml = iframe.contentDocument.documentElement;
        
        if (iframeBody) {
          removeScrollbars(iframeBody);
        }
        if (iframeHtml) {
          removeScrollbars(iframeHtml);
        }
      }
    } catch (e) {
      // Ignore cross-origin errors
    }
  });

  // Adicionar estilo CSS temporário para forçar remoção de scrollbars
  const tempStyle = document.createElement('style');
  tempStyle.id = 'temp-print-style';
  tempStyle.textContent = `
    @media print {
      *, *::before, *::after {
        overflow: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
      }
      
      *::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
      }
      
      html, body {
        overflow: visible !important;
        height: auto !important;
      }
      
      iframe {
        overflow: visible !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
      }
    }
  `;
  document.head.appendChild(tempStyle);

  // Aguardar um pouco mais para garantir que as mudanças sejam aplicadas
  await new Promise(resolve => setTimeout(resolve, 1000));

  // Dispara impressão
  window.print();

  // Restaura após impressão
  setTimeout(() => {
    // Remover estilo temporário
    const tempStyleEl = document.getElementById('temp-print-style');
    if (tempStyleEl) {
      tempStyleEl.remove();
    }

    // Restaurar estilos originais
    elementsToHide.forEach((el, index) => {
      if (originalStyles[index]) {
        el.style.display = originalStyles[index].display;
        el.style.visibility = originalStyles[index].visibility;
        el.style.position = originalStyles[index].position;
        el.style.left = originalStyles[index].left;
        el.style.top = originalStyles[index].top;
        el.style.width = originalStyles[index].width;
        el.style.height = originalStyles[index].height;
        el.style.opacity = originalStyles[index].opacity;
        el.style.overflow = originalStyles[index].overflow;
        el.style.overflowX = originalStyles[index].overflowX;
        el.style.overflowY = originalStyles[index].overflowY;
      }
    });
    
    this.showPrint = false;
    this.loading = false;
  }, 1000);
},
  },
});